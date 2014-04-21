<?php

	// Inialize session
	session_start();

	// Check, if username session is NOT set then this page will jump to login page
	if (!isset($_SESSION['userid'])) {
	header('Location: login.php');
	}

	if ($_SESSION['type'] != "admin") {
		// $link  = $_SESSION['type'] . "_home.php";
		$redir  = "Location: " . $_SESSION['type'] . "_home.php";
	    header($redir);
	}

	$errors = "";
	$is_error = 0;

	if (isset($_POST['username']) && !empty($_POST["username"]))
	{
		// echo $_POST['username'];
	    $_POST["username"] = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
	    if ($_POST["username"] == "")
	    {
	        $errors .= 'Please enter a valid name.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$name = $_POST["username"];
	} else {
	    $errors .= 'Please enter your name.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['dob']) && !empty($_POST["dob"]))
	{
		$cur_date = date("Y-m-d");
		// echo $cur_date . "<br/>";
		if($cur_date < $_POST['dob'] ){
			// echo "error...";
			$is_error = 1;
			$errors .= 'Please enter a valid date of birth. <br/>';
		}
		else
			$dob = $_POST['dob'];

	}  else {
	    $errors .= 'Please enter your Date of Birth.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['address']) && !empty($_POST["address"]))
	{
		$_POST["address"] = filter_var($_POST["address"], FILTER_SANITIZE_STRING);
	    if ($_POST["address"] == "")
	    {
	        $errors .= 'Please enter a valid address.<br/>';
	        $is_error = 1;
	    }
	    else
			$address=$_POST['address'];
	}  else {
	    $errors .= 'Please a address.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['phone_no']) && !empty($_POST["phone_no"]))
		$phone_no=$_POST['phone_no'];
	else {
	    $errors .= 'Please enter valid phone number.<br/>';
	    $is_error = 1;
	}
	if (isset($_POST['salary']) && !empty($_POST["salary"]))
		$salary=$_POST['salary'];
	else {
	    $errors .= 'Please enter correct salary.<br/>';
	    $is_error = 1;
	}
	
		if (isset($_POST['designation']) && !empty($_POST["designation"]))
	{
		// echo $_POST['username'];
	    $_POST["designation"] = filter_var($_POST["designation"], FILTER_SANITIZE_STRING);
	    if ($_POST["designation"] == "")
	    {
	        $errors .= 'Please enter a valid designation.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$designation = $_POST["designation"];
	} else {
	    $errors .= 'Please enter your designation.<br/>';
	    $is_error = 1;
	}
			if (isset($_POST['type']) && !empty($_POST["type"]))
	{
		// echo $_POST['username'];
	    $_POST["type"] = filter_var($_POST["type"], FILTER_SANITIZE_STRING);
	    if ($_POST["type"] == "")
	    {
	        $errors .= 'Please enter a valid type.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$type = $_POST["type"];
	} else {
	    $errors .= 'Please enter your type.<br/>';
	    $is_error = 1;
	}
	if (isset($_POST['appointment_charge']) && !empty($_POST["appointment_charge"]))
		$appointment_charge=$_POST['appointment_charge'];
	else {
	    $errors .= 'Please enter valid appointment_charge.<br/>';
	    $is_error = 1;
	}
	if (isset($_POST['doc_st']))
		$doc_st=$_POST['doc_st'];
	else {
	    $errors .= 'Please enter valid start time of doctor.<br/>';
	    $is_error = 1;
	}
	if (isset($_POST['doc_et']))
		$doc_et=$_POST['doc_et'];
	else {
	    $errors .= 'Please enter valid end time of doctor.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['operation_charge']) && !empty($_POST["operation_charge"]))
		$operation_charge=$_POST['operation_charge'];
	else {
	    $errors .= 'Please enter valid operation_charge.<br/>';
	    $is_error = 1;
	}




	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	     header('Location: ../reg_doctor.php?error='.urlencode($msg));
	    echo $errors;
	}

	// select database and setup connection

	$con=mysql_connect('localhost','root','');
	if (!$con) {
    	die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('hospital');

	$query="INSERT INTO doctor (`doctor_name`, `dob`, `address`, `salary`, `contact`, `designation`, `type`, `appointment_charge`, `operation_charge`) VALUES ('$name', '$dob', '$address',  '$salary', '$phone_no', '$designation', '$type', '$appointment_charge', '$operation_charge');";
	echo $query;

	if(mysql_query($query,$con))
	{
		 echo 'inerted';
		$doctor_id = mysql_insert_id();

		$query2 = "INSERT INTO doctor_slot (`doctor_id`, `start_time`, `end_time`) VALUES ('$doctor_id', '$doc_st', '$doc_et');";
		if(mysql_query($query2))
		{
			$login_query = "INSERT INTO login (`user_id`, `user_name`, `type`, `password`) VALUES ('$doctor_id', '$name', 'doctor', '$name');";
			if(mysql_query($login_query))
			{
				$status = "Doctor record added successfull.\\nDoctor Registration Number = " . $doctor_id;
				header('Location: ../rep_home.php?status='.urlencode($status));
			}
		}
		else
		{
			$status = "Dcotor slot time not updates try again";
			header('Location: ../rep_home.php?status='.urlencode($status));
		}
	}
	
	mysql_close($con);
?>