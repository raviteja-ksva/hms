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

	




	
	if (isset($_POST['room_no']) && !empty($_POST["room_no"]))
		$room_no=$_POST['room_no'];
	else {
	    $errors .= 'Please enter valid Room number.<br/>';
	    $is_error = 1;
	}

		if (isset($_POST['room_type']) && !empty($_POST["room_type"]))
	{
		// echo $_POST['username'];
	    $_POST["room_type"] = filter_var($_POST["room_type"], FILTER_SANITIZE_STRING);
	    if ($_POST["room_type"] == "")
	    {
	        $errors .= 'Please enter a valid Room type.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$room_type = $_POST["room_type"];
	} else {
	    $errors .= 'Please enter Room type.<br/>';
	    $is_error = 1;
	}


	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	     header('Location: ../reg_room.php?error='.urlencode($msg));
	    echo $errors;
	}

	// select database and setup connection
	else{

	$con=mysql_connect('localhost','root','');
	if (!$con) {
    	die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('hospital');

	$query="INSERT INTO room (`room_no`,`room_type`) VALUES ('$room_no','$room_type');";
	echo $query;
	if(mysql_query($query))
	{
		// echo 'inerted';
	//	$accountant_id = mysql_insert_id();
		$status = "Roomadded successfully.\\nRoom Number = " . $room_no;
		header('Location: ../rep_home.php?status='.urlencode($status));
	}
	mysql_close($con);
}
?>