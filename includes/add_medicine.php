<?php

	// Inialize session
	session_start();

	// Check, if username session is NOT set then this page will jump to login page
	if (!isset($_SESSION['userid'])) {
	header('Location: login.php');
	}

	if ($_SESSION['type'] != "ph") {
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
	        $errors .= 'Please enter a valid  medicine name.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$med_name = $_POST["username"];
	} else {
	    $errors .= 'Please enter medicine name.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['exp_date']) && !empty($_POST["exp_date"]))
	{
		$cur_date = date("Y-m-d");
		// echo $cur_date . "<br/>";
		if($cur_date > $_POST['exp_date'] ){
			// echo "error...";
			$is_error = 1;
			$errors .= 'Medicine has already expired !!!. <br/>';
		}
		else
			$exp_date = $_POST['exp_date'];

	}  else {
	    $errors .= 'Please enter expiry date.<br/>';
	    $is_error = 1;
	}

	

	if (isset($_POST['batchno']) && !empty($_POST["batchno"]))
		$batchno=$_POST['batchno'];
	else {
	    $errors .= 'Please enter batch number.<br/>';
	    $is_error = 1;
	}
	
		if (isset($_POST['stock']) && !empty($_POST["stock"]))
		$stock=$_POST['stock'];
	else {
	    $errors .= 'Please enter valid stock.<br/>';
	    $is_error = 1;
	}

	

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../reg_medicine.php?error='.urlencode($msg));
	    echo $errors;
	}

	// select database and setup connection

	$con=mysql_connect('localhost','root','');
	if (!$con) {
    	die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('hospital');

	$query="INSERT INTO medicine (`med_name`, `batch_no`, `exp_date`, `stock`) VALUES ('$med_name', '$batchno', '$exp_date', '$stock');";
	echo $query;
	if(mysql_query($query))
	{
		// echo 'inerted';
		//$patient_id = mysql_insert_id();
		$status = "Medicine record added successfull. ";
		header('Location: ../rep_home.php?status='.urlencode($status));
	}
	mysql_close($con);
?>