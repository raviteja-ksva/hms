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

    echo $_POST['wb_id'] . "<br/>";
    echo $_POST['room_no'] . "<br/>";
    // echo $_POST['patient_id'] . "<br/>";


    if (isset($_POST['wb_id']) && isset($_POST["room_no"])){
        $wb_id = $_POST['wb_id'];
        $room_no = $_POST['room_no'];
    }
    else {
        $errors .= 'Please enter valid data.<br/>';
        $is_error = 1;
    }

    if($is_error == 1 || $errors != "")
    {
        $msg=$errors;
        header('Location: ../clear_room_service.php?error='.urlencode($msg));
        echo $errors;
    }
    else
    {
        $con=mysql_connect('localhost','root','');
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db('hospital');

        $query = "UPDATE  cleaning_service SET  `service_end_time` =  '$cur_time', service_status =1 WHERE  wb_id =$wb_id AND  room_no =  '$room_no'  AND service_status =0 AND service_end_time IS NULL LIMIT 1  ;";
        //echo $query;

       // $query2 = "UPDATE ambulance SET `avail_status`='1' WHERE `amb_number`='$amb_number';";

        $query3 = "UPDATE ward_boy SET `avail`='1' WHERE `wb_id`='$wb_id';";

        echo $query . "<br/>";
        if(mysql_query($query))
        {
            $rc = mysql_affected_rows();
            echo "Records effected: " . $rc;
            if($rc == 0)
            {
                $status = "ward boy went to different room.";
                header('Location: ../clear_room_service.php?error='.urlencode($status));
                echo $status. "<br/>";
                // return;
            }else
            {
               
                    if(mysql_query($query3))
                    {   
                        $status = "Room Service  ended successfully";
                        header('Location: ../rep_home.php?status='.urlencode($status));
                    }else
                    {
                        $status = "Try again. ward boy is already free";
                        header('Location: ../clear_room_service.php?status='.urlencode($status));
                    }
                
            }
        }else{
            $status = "Try again";
           header('Location: ../clear_room_service.php?error='.urlencode($status));
        }
        echo $status . "<br/>";
        mysql_close($con);
    }


?>