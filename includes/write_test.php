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
	// $pre_date = date('Y-m-d');

	echo $_POST['patient_id'] . "<br/>";
	echo $_POST['lt_id']. "<br/>";
	echo $_POST['test_date']. "<br/>";

	if (isset($_POST['patient_id']))
		$patient_id=$_POST['patient_id'];
	else {
	    $errors .= 'Please enter correct patient registration number.<br/>';
	    $is_error = 1;
	}

	// if (isset($_POST['lt_id']))
	// {
	// 	$lt_id=$_POST['lt_id'];
	// }  else {
	//     $errors .= 'Please select correct lab teck .<br/>';
	//     $is_error = 1;
	// }

	if (isset($_POST['test_id']))
	{
		$test_id=$_POST['test_id'];
	}  else {
	    $errors .= 'Please select correct lab teck .<br/>';
	    $is_error = 1;
	}

	// if (isset($_POST['test_date']))
	// {
	// 	$test_date=$_POST['test_date'];
	// }  else {
	//     $errors .= 'Please select valid test date.<br/>';
	//     $is_error = 1;
	// }

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../give_test.php?error='.urlencode($msg));
	    echo $errors;
	}else
	{
		$con=mysql_connect('localhost','root','');
		if (!$con) {
	    	die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('hospital');
		
		$query = "INSERT INTO test_transaction (`test_id`, `patient_id`) VALUES ('$test_id', '$patient_id');";
		if(mysql_query($query))
		{
			$status = "Test added successfull";
			header('Location: ../give_prex.php?status='.urlencode($status));
		}else
		{
			$status = "Try Again";
			header('Location: ../give_test.php?error='.urlencode($status));
		}

		mysql_close($con);
	}

?>