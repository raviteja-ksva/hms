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
        // header('Location: ../pay_bill.php?error='.urlencode($msg));
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
        while($row = mysql_fetch_assoc($result))
        {
            $med_tx_id = $row["med_tx_id"];
            $query2 = "UPDATE  `hospital`.`med_tx` SET  `paid` =  '1' WHERE  `med_tx`.`med_tx_id` =$med_tx_id;";
            if(mysql_query($query2))
            {
                //
            }else
            {
                $status = "Try again";
                header('Location: ../pay_bill.php?status='.urlencode($status));
                echo $status;
            }
        }

        $query3 = "select test_tx_id from test_transaction where patient_id=$patient_id and paid = 0;";
        $result3 = mysql_query($query3);
        while($row = mysql_fetch_assoc($result3))
        {
            $test_tx_id = $row["test_tx_id"];
            $query2 = "UPDATE  test_transaction SET  `paid` =  '1' WHERE  test_tx_id =$test_tx_id;";
            if(mysql_query($query2))
            {
                //
            }else
            {
                $status = "Try again";
                header('Location: ../pay_bill.php?status='.urlencode($status));
                echo $status;
            }            
        }

        $status = "Paid successfully";
        header('Location: ../home.php?status='.urlencode($status));
        echo $status;   
    }
?>