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

    $repid = $_SESSION['userid'];
    // $cur_date = date('Y-m-d');
    $cur_time = date('H:i:s');

    echo $_POST['nrs_id'] . "<br/>";
    echo $_POST['patient_id'] . "<br/>";
    // echo $_POST['patient_id'] . "<br/>";


    if (isset($_POST['nrs_id']) && isset($_POST["patient_id"])){
        $nrs_id = $_POST['nrs_id'];
        $patient_id = $_POST['patient_id'];
    }
    else {
        $errors .= 'Please enter valid data.<br/>';
        $is_error = 1;
    }

    if($is_error == 1 || $errors != "")
    {
        $msg=$errors;
        header('Location: ../clear_nurse_service.php?error='.urlencode($msg));
        echo $errors;
    }
    else
    {
        $con=mysql_connect('localhost','root','');
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db('hospital');

        $query = "UPDATE  nursing_service SET   service_status =1 WHERE  nrs_id =$nrs_id AND  patient_id =  '$patient_id'   ;";
        //echo $query;

       // $query2 = "UPDATE ambulance SET `avail_status`='1' WHERE `amb_number`='$amb_number';";

       // $query3 = "UPDATE ward_boy SET `avail`='1' WHERE `wb_id`='$wb_id';";

        echo $query . "<br/>";
        if(mysql_query($query))
        {
            $rc = mysql_affected_rows();
            echo "Records effected: " . $rc;
            if($rc == 0)
            {
                $status = "Nurse sent to different person.";
                header('Location: ../clear_nurse_service.php?error='.urlencode($status));
                echo $status. "<br/>";
                // return;
            }else
            {
               
                   $status = "Nurse Service  ended successfully";
                        header('Location: ../rep_home.php?status='.urlencode($status));
                
            }
        }else{
            $status = "Try again";
           header('Location: ../clear_nurse_service.php?error='.urlencode($status));
        }
        echo $status . "<br/>";
        mysql_close($con);
    }


?>