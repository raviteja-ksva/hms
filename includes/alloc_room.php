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
    //$cur_time = date('H:i:s');

    echo $_POST['patient_id'] . "<br/>";
    echo $_POST['room_no'] . "<br/>";
   // echo $_POST['patient_id'] . "<br/>";

    if ( !empty($_POST["patient_id"]) )
        $patient_id = $_POST['patient_id'];
    else {
        $errors .= 'Please enter valid Patients registration number.<br/>';
        $is_error = 1;
    }

    if (isset($_POST['room_no'])) {
        $room_no = $_POST['room_no'];
       // $amb_number = $_POST['amb_number'];
    }
    else {
        $errors .= 'Please enter valid data.<br/>';
        $is_error = 1;
    }

    if($is_error == 1 || $errors != "")
    {
        $msg=$errors;
        header('Location: ../allocate_room.php?error='.urlencode($msg));
        echo $errors;
    }
    else
    {
        $con=mysql_connect('localhost','root','');
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db('hospital');

        $query = "INSERT INTO admission (`patient_id`, `room_no`, `admission_date`, `rep_id`) VALUES ('$patient_id', '$room_no', '$cur_date', '$repid');";
        //echo $query;
        $query2 = "UPDATE room SET `avail`='0' WHERE `room_no`='$room_no';";

       // $query3 = "UPDATE driver SET `avail`='2' WHERE `driver_id`='$driver_id';";

     //   echo $query . "<br/>";
        if(mysql_query($query))
        {
            if(mysql_query($query2))
            {
            	$status = "room  allocated successfully";
                    header('Location: ../rep_home.php?status='.urlencode($status));
               
            }else
            {
                $status = "Error in assigning a room";
                header('Location: ../allocate_room.php?status='.urlencode($status));
            }
        }else{
            $status = "Invalid Medical Registration Number";
            header('Location: ../allocate_room.php?error='.urlencode($status));
        }
        // echo $status . "<br/>";
        mysql_close($con);
    }


?>