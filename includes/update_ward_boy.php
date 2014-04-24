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
	$wb_id=$_POST['wb_id_2'];
	// echo patient_id;

	if (isset($_POST['wb_name']) && !empty($_POST["wb_name"]))
	{
		// echo $_POST['username'];
	    $_POST["wb_name"] = filter_var($_POST["wb_name"], FILTER_SANITIZE_STRING);
	    if ($_POST["wb_name"] == "")
	    {
	        $errors .= 'Please enter a valid name.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$name = $_POST["wb_name"];
	} else {
	    $errors .= 'Please enter Ward boy name.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['wb_dob']) && !empty($_POST["wb_dob"]))
	{
		$cur_date = date("Y-m-d");
		// echo $cur_date . "<br/>";
		if($cur_date < $_POST['wb_dob'] ){
			// echo "error...";
			$is_error = 1;
			$errors .= 'Please enter a valid date. <br/>';
		}
		else
			$dob = $_POST['wb_dob'];

	}  else {
	    $errors .= 'Please enter Ward boy Date of Birth.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['wb_add']) && !empty($_POST["wb_add"]) && trim($_POST["wb_add"]) != "")
	{
		$_POST["wb_add"] = filter_var($_POST["wb_add"], FILTER_SANITIZE_STRING);
	    if ($_POST["wb_add"] == "")
	    {
	        $errors .= 'Please enter a valid address.<br/>';
	        $is_error = 1;
	    }
	    else
			$address=$_POST['wb_add'];
	}  else {
	    $errors .= 'Please a address.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['wb_phone']) && !empty($_POST["wb_phone"]))
		$phone_no=$_POST['wb_phone'];
	else {
	    $errors .= 'Please enter Ward boy phone number.<br/>';
	    $is_error = 1;
	}
	if (isset($_POST['wb_salary']) && !empty($_POST["wb_salary"]))
		$salary=$_POST['wb_salary'];
	else {
	    $errors .= 'Please enter Ward boy salary.<br/>';
	    $is_error = 1;
	}
if (isset($_POST['wb_shift']) && !empty($_POST["wb_shift"]))
	{
		$shift=$_POST['w_shift'];
	}  else {
	    $errors .= 'Please enter your shift.<br/>';
	    $is_error = 1;
	}
	if (isset($_POST['wb_avail']) && !empty($_POST["wb_avail"]))
		$avail=$_POST['wb_avail'];
	else {
	    $errors .= 'Please enter Ward boy Availabilty.<br/>';
	    $is_error = 1;
	}
	

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../edit_ward_boy.php?error='.urlencode($msg));
	    echo $errors;
	}else {
		// select database and setup connection

		$con=mysql_connect('localhost','root','');
		if (!$con) {
	    	die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('hospital');

		$query = "UPDATE ward_boy SET `wb_name`='$name', `address`='$address', `contact`='$phone_no',  `dob`='$dob', `salery`='$salary', `shift`='$shift', `avail`='$avail' WHERE `wb_id`='$wb_id';" ;

		// echo $query;
		if(mysql_query($query))
		{
			// echo 'inerted';
			$wb_id = mysql_insert_id();
			$status = "Ward boy record updated successfull.";
			header('Location: ../admin_home.php?status='.urlencode($status));
		}
		mysql_close($con);
	}
?>