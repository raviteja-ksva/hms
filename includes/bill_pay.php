<?php

    session_start();

    // Check, if username session is NOT set then this page will jump to login page
    if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    }

    if ($_SESSION['type'] != "rep") {
        // $link  = $_SESSION['type'] . "_home.php";
        $redir  = "Location: " . $_SESSION['type'] . "_home.php";
        header($redir);
    }

    $errors = "";
    $is_error = 0;

    if ( isset($_POST["patient_id"]) )
        $patient_id = $_POST['patient_id'];
    else {
        $errors .= 'Please enter valid Patients registration number.<br/>';
        $is_error = 1;
    }

    if($is_error == 1 || $errors != "")
    {
        $msg=$errors;
        header('Location: ../bill_pay.php?error='.urlencode($msg));
        echo $errors;
    }else
    {
        $con=mysql_connect('localhost','root','');
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db('hospital');
        $query = "select med_name, number, med_tx_id from med_tx where patient_id = $patient_id and paid = '0';";
        echo $query . "<br/><br/>" ;
        $result = mysql_query($query);
        $cost = 0;
        echo '<table border="1">';
        echo '<tr><th>med_name</th><th>number</th><th>price</th></tr>';
        while($row = mysql_fetch_assoc($result))
        {

            echo '<tr>';
            echo '<td>'.$row['med_name'].'</td>';
            echo '<td>'.$row['number'].'</td>';
            

            $med_name = $row["med_name"];
            $num = $row["number"];
            // $price = $row["price"];

            $query2 = "select price from med_cost where med_name='$med_name';";
            // echo $query2 . "<br/>";
            $result2 = mysql_query($query2);
            if($row2 = mysql_fetch_assoc($result2))
            {
                $price = $row2["price"];
                $cost = $cost + $num * $price;
            }
            echo '<td>'.$price*$num.'</td>';
            echo '</tr>';
            // echo "cost is " .$cost . "<br/>";
        }
        echo "<h4> Total Medication Cost : ".$cost ."</h4><br/>";
        echo '</table> <br />';

        $cost2 = 0;
        $query2 = "select t1.test_id, t1.test_name, t1.cost from tests_info as t1, test_transaction as t2 where t1.test_id =t2.test_id and t1.test_id in (select test_id from test_transaction where patient_id=$patient_id and paid = 0);";
        echo $query2 . "<br/>";
        $result2 = mysql_query($query2);
        // $cost = 0;
        echo '<table border="1">';
        echo '<tr><th>Test_name</th><th>cost</th></tr>';
        while($row = mysql_fetch_assoc($result2))
        {
            echo '<tr>';
            echo '<td>'.$row['test_name'].'</td>';
            echo '<td>'.$row['cost'].'</td>';
            $cost2 = $cost2 + $row['cost'];
            echo '</tr>';
        }
        echo '</table> <br />';
        echo "<h4> Total Tests Cost : ".$cost2 ."</h4><br/>";
        $status = "Total amount = " . $cost;
        // echo $status . "<br/>";
        // header('Location: ../rep_home.php?status='.urlencode($status));
        echo "<h4> Total : ".($cost + $cost2) ."</h4><br/>";
    }
?>

<form action= "pay_amnt.php" method="POST">
    <input type="hidden" name="patient_id" id = "patient_id" value="<?php echo $patient_id; ?>">
   <div class="line submit"><input type="submit" value="Pay" /></div>
</form>