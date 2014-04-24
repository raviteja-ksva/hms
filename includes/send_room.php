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
   

    echo $_POST['wb_id'] . "<br/>";
    echo $_POST['room_no'] . "<br/>";
    //echo $_POST['patient_id'] . "<br/>";

    

    if (isset($_POST['wb_id']) && isset($_POST["room_no"]) ){
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
        header('Location: ../room_service.php?error='.urlencode($msg));
        echo $errors;
    }
    else
    {
        $con=mysql_connect('localhost','root','');
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db('hospital');

        $query = "INSERT INTO cleaning_service (`wb_id`, `room_no`, `rep_id`,  `service_date`, `service_time`, `service_end_time`) VALUES ('$wb_id', '$room_no', '$repid', '$cur_date', '$cur_time', NULL);";

       // $query2 = "UPDATE room SET `avail`='0' WHERE `room_no`='$room_no';";

        $query3 = "UPDATE ward_boy SET `avail`='0' WHERE `wb_id`='$wb_id';";

        echo $query . "<br/>";
        if(mysql_query($query))
        {
           
            
                if(mysql_query($query3))
                {   
                    $status = "ward boy sent successfully";
                    header('Location: ../rep_home.php?status='.urlencode($status));
                }else
                {
                    $status = "Try again. ward boy is not available";
                    header('Location: ../room_service.php?status='.urlencode($status));
                }
            
            
        }else{
            $status = "Failed in entering in cleaning service table";
            header('Location: ../room_service.php?error='.urlencode($status));
        }
        // echo $status . "<br/>";
        mysql_close($con);
    }


?>