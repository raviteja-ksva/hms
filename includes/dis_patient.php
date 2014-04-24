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
   // $cur_time = date('H:i:s');

    echo $_POST['patient_id'] . "<br/>";
    echo $_POST['room_no'] . "<br/>";
    // echo $_POST['patient_id'] . "<br/>";


    if (isset($_POST['patient_id']) && isset($_POST["room_no"])){
        $patient_id = $_POST['patient_id'];
        $room_no = $_POST['room_no'];
    }
    else {
        $errors .= 'Please enter valid data.<br/>';
        $is_error = 1;
    }

    if($is_error == 1 || $errors != "")
    {
        $msg=$errors;
        header('Location: ../discharge_patient.php?error='.urlencode($msg));
        echo $errors;
    }
    else
    {
        $con=mysql_connect('localhost','root','');
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }

        mysql_select_db('hospital');
        $query="select admission_date from admission where patient_id ='$patient_id' AND  room_no =  '$room_no' ;";
        echo $query."<br/>";
        $result =mysql_query($query);
        if(mysql_query($query))
        {
            $row=mysql_fetch_array($result);
        }

        $query = "UPDATE  admission SET  `discharge_date` =  '$cur_date' WHERE  patient_id =$patient_id AND  room_no =  '$room_no'    ;";
        //echo $query;

       // $query2 = "UPDATE ambulance SET `avail_status`='1' WHERE `amb_number`='$amb_number';";

        $query3 = "UPDATE room SET `avail`='1' WHERE `room_no`='$room_no';";

        echo $query . "<br/>";
        if(mysql_query($query))
        {
            $rc = mysql_affected_rows();
            echo "Records effected: " . $rc;
            if($rc == 0)
            {
                $status = "Patient assigned a different room.";
                header('Location: ../discharge_patient.php?error='.urlencode($status));
                echo $status. "<br/>";
                // return;
            }else
            {
               
                    if(mysql_query($query3))
                    {   
                        $status = "Patient discharged successfully";
                            header('Location: ../rep_home.php?error='.urlencode($status));
       

                        //$diff=$cur_date - $row["admission_date"];
                      //  echo "days=". $days;
                       // header('Location: ../rep_home.php?status='.urlencode($status));
                    }else
                    {
                        $status = "Try again. ";
                        header('Location: ../discharge_patient.php?status='.urlencode($status));
                    }
                
            }
        }else{
            $status = "Try again";
           header('Location: ../discharge_patient.php?error='.urlencode($status));
        }
        echo $status . "<br/>";
        mysql_close($con);
    }


?>