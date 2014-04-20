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
    $cur_date = date('Y-m-d');
    $cur_time = date('H:i:s');

    echo $_POST['driver_id'] . "<br/>";
    echo $_POST['amb_number'] . "<br/>";
    echo $_POST['patient_id'] . "<br/>";

    if ( !empty($_POST["patient_id"]) )
        $patient_id = $_POST['patient_id'];
    else {
        $errors .= 'Please enter valid Patients registration number.<br/>';
        $is_error = 1;
    }

    if (isset($_POST['driver_id']) && isset($_POST["amb_number"])){
        $driver_id = $_POST['driver_id'];
        $amb_number = $_POST['amb_number'];
    }
    else {
        $errors .= 'Please enter valid data.<br/>';
        $is_error = 1;
    }

    if($is_error == 1 || $errors != "")
    {
        $msg=$errors;
        header('Location: ../amb_service.php?error='.urlencode($msg));
        echo $errors;
    }
    else
    {
        $con=mysql_connect('localhost','root','');
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db('hospital');

        $query = "INSERT INTO amb_service (`driver_id`, `amb_number`, `patient_id`, `rep_id`, `service_date`, `service_time`, `service_end_time`) VALUES ('$driver_id', '$amb_number', '$patient_id', '$repid', '$cur_date', '$cur_time', NULL);";

        $query2 = "UPDATE ambulance SET `avail_status`='0' WHERE `amb_number`='$amb_number';";

        $query3 = "UPDATE driver SET `avail`='0' WHERE `driver_id`='$driver_id';";

        echo $query . "<br/>";
        if(mysql_query($query))
        {
            if(mysql_query($query2))
            {
                if(mysql_query($query3))
                {   
                    $status = "Ambulance sent successfully";
                    header('Location: ../rep_home.php?status='.urlencode($status));
                }else
                {
                    $status = "Try again. Driver is not available";
                    header('Location: ../amb_service.php?status='.urlencode($status));
                }
            }else
            {
                $status = "Try again. Ambulance is not available";
                header('Location: ../amb_service.php?status='.urlencode($status));
            }
        }else{
            $status = "Invalid Medical Registration Number";
            header('Location: ../amb_service.php?error='.urlencode($status));
        }
        // echo $status . "<br/>";
        mysql_close($con);
    }


?>