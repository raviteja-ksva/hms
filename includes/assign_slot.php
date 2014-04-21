<html>
<head>

<?php

	// Inialize session
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

	if(!isset($_POST['slot_time']))
	{
		echo $_POST['doc_id'] . "<br/>";
		echo $_POST['patient_id'] . "<br/>";
		echo $_POST['app_date'] . "<br/>";

		$errors = "";
		$is_error = 0;

		if (isset($_POST['patient_id']))
		{
		   	$patient_id = $_POST["patient_id"];
		} else {
		    $errors .= 'Please enter valid patient registration number.<br/>';
		    $is_error = 1;
		}
	  	if (isset($_POST['doc_id']) && isset($_POST["app_date"])){
	        $doctor_id = $_POST['doc_id'];
	        $app_date = $_POST['app_date'];
	    }
	    else {
	        $errors .= 'Please enter valid data.<br/>';
	        $is_error = 1;
	    }

	    if($is_error == 1 || $errors != "")
	    {
	        $msg=$errors;
	        // header('Location: ../book_appt.php?error='.urlencode($msg));
	        echo $errors;
	    }else
	    {
	    	$con=mysql_connect('localhost','root','');
	        if (!$con) {
	            die('Could not connect: ' . mysql_error());
	        }
	        mysql_select_db('hospital');

	        $query = "select start_time, end_time from doctor_slot where doctor_id = $doctor_id;";
	        echo $query ."<br/>" ;
	        $result = mysql_query($query);
	        if ($row = mysql_fetch_assoc($result)) {
			    // printf("ID: %s  Name: %s", $row[0], $row[1]);
			    $doc_st = $row["start_time"];
	        	$doc_et = $row["end_time"];

	        	echo $doc_st . "<br/>";
				echo $doc_et . "<br/>";  
			}else
			{
				$status = "Try again.";
	            // header('Location: ../book_appt.php?error='.urlencode($status));
	            echo $status . "<br/>";
			}
			// run a for loop
			$time =  ($doc_et - $doc_st)*2 ;
			echo $time ."<br/>";
			include('functions.php');
			// echo addtime($doc_et, $doc_st) ."<br/>";

			$query = "select start_time, end_time from appointment where doctor_id=$doctor_id and app_date='$app_date' order by start_time;";
			// echo $query ."<br/>" ;
			// $result = mysql_query($query);
			// start loop here...
			// $temp = $doc_st;
			echo "<p> Choose slot time </p>";
			echo '<select name="slot_time" id="slot_time" form="choose_slot"> ';
			for($temp = $doc_st; $temp < $doc_et ; $temp = addtime($temp, "00:30:00") )
			{
				$query2 = "select app_id from appointment where doctor_id=$doctor_id and app_date='$app_date' and start_time='$temp' ;";
				// echo $query2 ."<br/>";
				if(mysql_query($query2))
				{
					$rc = mysql_affected_rows();
	        		// echo "Records effected: " . $rc . "<br/>";
	        		if($rc == 0)
	        		{
	        			echo "<option value='$temp'>$temp</option>";
	        		}
				}
				// $temp = addtime($temp, "00:30:00");
				echo $temp . "<br/>";
			}
			echo "</select>";

	        mysql_close($con);
	    }
	}
	else{
		include('functions.php');

		// echo "hi";
		$doctor_id = $_POST['doctor_id'];
		$patient_id = $_POST['patient_id'];
		$start_time = $_POST['slot_time'];
		$end_time = addtime($start_time, "00:30:00");
		$rep_id = $_SESSION['userid'];
	    $app_date = $_POST['app_date'];

		$con=mysql_connect('localhost','root','');
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db('hospital');

        $query = "INSERT INTO appointment (`patient_id`, `doctor_id`, `app_date`, `rep_id`, `start_time`, `end_time`) VALUES ('$patient_id', '$doctor_id', '$app_date', '$rep_id', '$start_time', '$end_time');";
        if(mysql_query($query))
        {
        	$app_id = mysql_insert_id();
        	$status = " successfully";
        	$status = "Appiontment booked successfull.\\nAppointment id = " . $app_id;
            header('Location: ../rep_home.php?status='.urlencode($status));
        }else {
        	$status = "Try again.";
	        // header('Location: ../book_appt.php?error='.urlencode($status));
        }        

        echo $query ."<br/>" ;
	}
?>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>"  id="choose_slot" method="POST">
		<input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>" >
		<input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>" >
		<input type="hidden" name="app_date" value="<?php echo $app_date; ?>" >
		<div class="line submit"><input type="submit" value="Book" /></div>
	</form>
</body>
</html>