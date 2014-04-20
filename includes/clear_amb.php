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

    echo $_POST['driver_id'] . "<br/>";
    echo $_POST['amb_number'] . "<br/>";
    // echo $_POST['patient_id'] . "<br/>";


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
        header('Location: ../clear_amb_service.php?error='.urlencode($msg));
        echo $errors;
    }
    else
    {
        $con=mysql_connect('localhost','root','');
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db('hospital');

        $query = "UPDATE  amb_service SET  `service_end_time` =  '$cur_time', service_status =1 WHERE  driver_id =$driver_id AND  amb_number =  '$amb_number' AND service_status =0 AND service_end_time IS NULL LIMIT 1 ;";

        $query2 = "UPDATE ambulance SET `avail_status`='1' WHERE `amb_number`='$amb_number';";

        $query3 = "UPDATE driver SET `avail`='1' WHERE `driver_id`='$driver_id';";

        echo $query . "<br/>";
        if(mysql_query($query))
        {
            $rc = mysql_affected_rows();
            echo "Records effected: " . $rc;
            if($rc == 0)
            {
                $status = "Driver took different ambulance.";
                header('Location: ../clear_amb_service.php?error='.urlencode($status));
                echo $status. "<br/>";
                // return;
            }else
            {
                if(mysql_query($query2))
                {
                    if(mysql_query($query3))
                    {   
                        $status = "Ambulance Service set successfully";
                        header('Location: ../rep_home.php?status='.urlencode($status));
                    }else
                    {
                        $status = "Try again. Driver is already free";
                        header('Location: ../clear_amb_service.php?status='.urlencode($status));
                    }
                }else
                {
                    $status = "Try again. Ambulance is already available";
                    header('Location: ../clear_amb_service.php?status='.urlencode($status));
                }
            }
        }else{
            $status = "Try again";
            header('Location: ../clear_amb_service.php?error='.urlencode($status));
        }
        echo $status . "<br/>";
        mysql_close($con);
    }


?>