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
        echo '</table> <br />';




      //   $query2 = "select cost from med_cost where med_name='$med_name';";


            $query = "select room_no, admission_date, discharge_date  from admission where patient_id = $patient_id  and paid = 0";
            
        echo $query . "<br/><br/>" ;
        $result = mysql_query($query);
        $room_cost=0;
        $cost1 = 0;
        echo '<table border="1">';
        echo '<tr><th>Admission date</th><th>Discharge date</th><th>price</th></tr>';
        while($row = mysql_fetch_assoc($result))
        {
            $datetime1 = strtotime($row['admission_date']);
            $datetime2 = strtotime($row['discharge_date']);
            $rom=$row["room_no"];
             $query2 = "select t2.room_cost from room as t1, room_type as t2 where t1.room_type=t2.room_type and t1.room_no= $rom ;";
             echo $query2 ;
             $result2 = mysql_query($query2);
             if($row2 = mysql_fetch_assoc($result2))
            {
            //    $price = $row2["price"];
                $cost1 = $row2['room_cost'];
            }
              $secs = $datetime2 - $datetime1;// == <seconds between the two times>
    $days = $secs / 86400;
        $cost1=($days + 1)* $cost1;
      //  echo $days ;
            echo '<tr>';
            echo '<td>'.$row['admission_date'].'</td>';
            echo '<td>'.$row['discharge_date'].'</td>';
             echo '<td>'.$cost1.'</td>';
            
            $room_cost=$room_cost+$cost1;
    
        }
        echo '</table> <br />';








            $cost=$cost+$room_cost;
        $status = "Total amount = " . $cost;
        // header('Location: ../rep_home.php?status='.urlencode($status));
        echo "<h4> Total : ".$cost ."</h4><br/>";
    }
?>

<form action= "pay_amnt.php" method="POST">
    <input type="hidden" name="patient_id" id = "patient_id" value="<?php echo $patient_id; ?>">
   <div class="line submit"><input type="submit" value="Pay" /></div>
</form>
<form action= "../home.php" method="POST">
  <!-- //  <input type="hidden" name="patient_id" id = "patient_id" value="<?php echo $patient_id; ?>"> -->
   <div class="line submit"><input type="submit" value="back to home page " /></div>
</form>