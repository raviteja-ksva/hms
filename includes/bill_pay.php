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

    if ( !empty($_POST["patient_id"]) )
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
        echo $query . "<br/>" ;
        $result = mysql_query($query);
        $cost = 0;
        while($row = mysql_fetch_assoc($result))
        {
            $med_name = $row["med_name"];
            $num = $row["number"];
            // $price = $row["price"];

            $query2 = "select price from med_cost where med_name='$med_name';";
            echo $query2 . "<br/>";
            $result2 = mysql_query($query2);
            if($row2 = mysql_fetch_assoc($result2))
            {
                $price = $row2["price"];
                $cost = $cost + $num * $price;
            }

            // echo "cost is " .$cost . "<br/>";
        }
        $status = "Total amount = " . $cost;
        header('Location: ../rep_home.php?status='.urlencode($status));
        echo $cost ."<br/>";

    }

?>