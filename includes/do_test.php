<html>
<head>

<?php

	// Inialize session
	session_start();

	// Check, if username session is NOT set then this page will jump to login page
	if (!isset($_SESSION['userid'])) {
	header('Location: login.php');
	}

	if ($_SESSION['type'] != "lab_teck") {
		// $link  = $_SESSION['type'] . "_home.php";
		$redir  = "Location: " . $_SESSION['type'] . "_home.php";
	    header($redir);
	}

	$errors = "";
	$is_error = 0;
	$lt_id = $_SESSION['userid'];

	if(isset($_GET['status']))
    {
    	$status = $_GET['status'];
       	echo '<script type="text/javascript"> alert("' .  $status .'"); </script>';
		// header('Location: ../issue_med.php');       	
	}

	if (isset($_POST['test_tx_id']))
	{
	   	$test_tx_id = $_POST["test_tx_id"];
	} else {
	    $errors .= 'Please enter valid test_tx_id.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['test_date']))
	{
		$test_date=$_POST['test_date'];
	}  else {
	    $errors .= 'Please a test_date.<br/>';
	    $is_error = 1;
	}

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../view_tests.php?error='.urlencode($msg));
	    echo $errors;
	}else
	{
		$cur_date = date('Y-m-d');
		$con=mysql_connect('localhost','root','');
	    if (!$con) {
	        die('Could not connect: ' . mysql_error());
	    }
		mysql_select_db('hospital');

		$query = "UPDATE test_transaction SET test_date = '$cur_date', lt_id =$lt_id,  result_date = '$test_date' WHERE `test_tx_id` =$test_tx_id;";
		echo $query . "<br/>";
		if(mysql_query($query))
		{	
			$status = "Result date updated successfull.";
			header('Location: ../lab_teck_home.php?status='.urlencode($status));			
		}else
		{
			$status = "Failed. Try agian";
			header('Location: ../lab_teck_home.php?status='.urlencode($status));
		}

	}

?>