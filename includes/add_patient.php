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
			$errors .= 'Please enter a valid date. <br/>';
		}
		else
			$dob = $_POST['dob'];

	}  else {
	    $errors .= 'Please enter your Date of Birth.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['address']) && trim($_POST["address"], " \t.") !="")
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
	    $errors .= 'Please enter your phone number.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['sex']) && !empty($_POST["sex"]))
	{
		$sex=$_POST['sex'];
	}  else {
	    $errors .= 'Please enter your gender.<br/>';
	    $is_error = 1;
	}

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../reg_patient.php?error='.urlencode($msg));
	    echo $errors;
	}else
	{

		echo $name . "<br/>";
		echo $dob . "<br/>";
		echo $address . "<br/>";
		echo $phone_no . "<br/>";
		echo $sex . "<br/>";

		// select database and setup connection

			$con=mysql_connect('localhost','root','');
			if (!$con) {
		    	die('Could not connect: ' . mysql_error());
			}
			mysql_select_db('hospital');

			$query="INSERT INTO patient (`patient_name`, `address`, `contact`, `sex`, `dob`) VALUES ('$name', '$address', '$phone_no', '$sex', '$dob');";
			// echo $query;
			if(mysql_query($query))
			{
				// echo 'inerted';
				$patient_id = mysql_insert_id();

				$login_query = "INSERT INTO login (`user_id`, `user_name`, `type`, `password`) VALUES ('$patient_id', '$name', 'patient', '$name');";
				if(mysql_query($login_query))
				{
					$status = "Patient record added successfull.\\nPatient Medical Registration Number = " . $patient_id;
					header('Location: ../rep_home.php?status='.urlencode($status));
				}
			}

		mysql_close($con);
	}
?>