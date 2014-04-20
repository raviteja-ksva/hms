<?php

	// Inialize session
	session_start();

	// Check, if username session is NOT set then this page will jump to login page
	if (!isset($_SESSION['userid'])) {
	header('Location: login.php');
	}

	if ($_SESSION['type'] != "doctor") {
		// $link  = $_SESSION['type'] . "_home.php";
		$redir  = "Location: " . $_SESSION['type'] . "_home.php";
	    header($redir);
	}

	$errors = "";
	$is_error = 0;

	$doctor_id = $_SESSION['userid'];
	$pre_date = date('Y-m-d');

	echo $_POST['patient_id'] . "<br/>";
	echo $_POST['no_days']. "<br/>";
	echo $_POST['med_name']. "<br/>";

	if (isset($_POST['patient_id']))
		$patient_id=$_POST['patient_id'];
	else {
	    $errors .= 'Please enter correct patient registration number.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['no_days']))
	{
		$no_days=$_POST['no_days'];
	}  else {
	    $errors .= 'Please enter correct number of days of prescription.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['med_name']))
	{
		$med_name=$_POST['med_name'];
	}  else {
	    $errors .= 'Please select medicine name.<br/>';
	    $is_error = 1;
	}

	if (!isset($_POST['morning']) && !isset($_POST['afternoon']) && !isset($_POST['night']))
	{
	    $errors .= 'Please select prescription time.<br/>';
	    $is_error = 1;
	}else
	{
		$morning = isset($_POST['morning'])? 1:0;
		$afternoon = isset($_POST['afternoon'])? 1:0;
		$night = isset($_POST['night'])? 1:0;
	}

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../give_prex.php?error='.urlencode($msg));
	    echo $errors;
	}else
	{
		$con=mysql_connect('localhost','root','');
		if (!$con) {
	    	die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('hospital');
		$reqd_med = ($morning + $afternoon + $night)*$no_days;
		$query = "INSERT INTO prescription (`doctor_id`, `med_name`, `patient_id`, `pre_date`, `morning`, `afternoon`, `night`, `no_days`) VALUES ('$doctor_id', '$med_name', '$patient_id', '$pre_date', '$morning', '$afternoon', '$night', '$no_days');";

		$query1 = "select stock, batch_no from medicine where med_name='$med_name' and stock>='$reqd_med';";

		echo $query1 . "<br/>";
		$result = mysql_query($query1);
		$rc = mysql_affected_rows();
        echo "Records effected: " . $rc;
		if($rc > 0)
		{
			$row = mysql_fetch_array($result);
			$stock = $row["stock"];
			$batch_no = $row["batch_no"];
			$new_stock = $stock - $reqd_med;
			$query3 = "UPDATE  medicine SET  `stock`='$new_stock' WHERE  med_name='$med_name' AND  `medicine`.`batch_no` =$batch_no;";
			echo $query3 . "<br/>"; 
			if(mysql_query($query3))
			{
				echo $query . "<br/>";
				if(mysql_query($query))
				{
					$status = "Prescription added successfull";
					header('Location: ../give_prex.php?status='.urlencode($status));
				}
			}else
			{
				$status = "Stock updatation failed.\\nTry Again";
				header('Location: ../give_prex.php?error='.urlencode($status));
			}
		}
		else
		{
			$status = "Required Stock not available";
			header('Location: ../give_prex.php?status='.urlencode($status));
		}

		mysql_close($con);
	}

?>