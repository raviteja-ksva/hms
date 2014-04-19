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

	
	if (isset($_POST['patient_id']) )
	{
		$patient_id=$_POST['patient_id'];
	}  else {
	    $errors = 'Please enter valid patient_id.<br/>';
	    $msg=$errors;
	    header('Location: ../edit_patient.php?error='.urlencode($msg));
	    // echo $errors;
	}

	$query = "SELECT * FROM hospital.patient where patient_id = ?" ;


	if ($stmt = $con->prepare($query)) {
		$stmt->bind_param('i', $patient_id);  // Bind "$patient_id" to parameter.
	    $stmt->execute();
	    $stmt->bind_result($field1, $field2);
	    while ($stmt->fetch()) {
	        //printf("%s, %s\n", $field1, $field2);
	    }
	    $stmt->close();
	}

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
		$status = "Patient record added successfull.\\nPatient Medical Registration Number = " . $patient_id;
		header('Location: ../rep_home.php?status='.urlencode($status));
	}
	mysql_close($con);
?>