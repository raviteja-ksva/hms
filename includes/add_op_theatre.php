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

	




	
	if (isset($_POST['ot_room_no']) && !empty($_POST["ot_room_no"]))
		$ot_room_no=$_POST['ot_room_no'];
	else {
	    $errors .= 'Please enter correct Operation number.<br/>';
	    $is_error = 1;
	}
		if (isset($_POST['cost']) && !empty($_POST["cost"]))
		$cost=$_POST['cost'];
	else {
	    $errors .= 'Please enter correct Cost.<br/>';
	    $is_error = 1;
	}

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../reg_op_theatre.php?error='.urlencode($msg));
	    echo $errors;
	}

	// select database and setup connection
	else{

	$con=mysql_connect('localhost','root','');
	if (!$con) {
    	die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('hospital');

	$query="INSERT INTO op_theatre (`ot_room_no`,`cost`) VALUES ('$ot_room_no','$cost');";
	echo $query;
	if(mysql_query($query))
	{
		// echo 'inerted';
	//	$accountant_id = mysql_insert_id();
		$status = "Operation Theatre added successfully.\\nOperation Theatre Number = " . $ot_room_no;
		header('Location: ../rep_home.php?status='.urlencode($status));
	}
	mysql_close($con);
}
?>