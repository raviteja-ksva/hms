<html>
<head>

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
	$ph_id = $_SESSION['userid'];

	if (isset($_POST['patient_id']))
	{
	   	$patient_id = $_POST["patient_id"];
	} else {
	    $errors .= 'Please enter valid patient registration number.<br/>';
	    $is_error = 1;
	    // echo '<script type="text/javascript"> alert("HI"); </script>';
	}

	if (isset($_POST['med_name']))
	{
	   	$med_name = $_POST["med_name"];
	} else {
	    $errors .= 'Please Select medicine.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['num']))
	{
	   	$num = $_POST["num"];
	} else {
	    $errors .= 'Please enter valid number of medicines.<br/>';
	    echo '<script type="text/javascript"> alert("Please enter valid number of medicines"); </script>';
	    $is_error = 1;
	}

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../issue_med.php?error='.urlencode($msg));
	    echo $errors;
	}else
	{

		echo $patient_id . "<br/>";
		echo $med_name . "<br/>";
		echo $num . "<br/>";

		$con=mysql_connect('localhost','root','');
	    if (!$con) {
	        die('Could not connect: ' . mysql_error());
	    }
		mysql_select_db('hospital');

		$query = "select stock, batch_no from medicine where med_name='$med_name' and stock >='$num';";
		echo $query . "<br/>";

		echo $query . "<br/>";
		$result = mysql_query($query);
		$rc = mysql_affected_rows();
	    echo "Records effected: " . $rc . "<br/>";
		if($rc > 0)
		{
			// $row = mysql_fetch_array($result);
			// $stock = $row["stock"];
			// $batch_no = $row["batch_no"];
			// $new_stock = $stock - $num;
			// // $new_stock = ;
			// $query3 = "UPDATE  medicine SET  `stock`='$new_stock' WHERE  med_name='$med_name' AND  `medicine`.`batch_no` =$batch_no;";

			$query2 = "INSERT INTO med_tx (`patient_id`, `ph_id`, `med_name`, `number`) VALUES ('$patient_id', '$ph_id', '$med_name', '$num');";
			
			if(mysql_query($query2))
			{
				$status = "Prescription given successfull";
				header('Location: ../issue_med.php?status='.urlencode($status));
				echo $status . "<br/>";
			}else
			{
				echo $query2 . "<br/>" ;
			}

		}else
		{
			$status = "Required Stock not available";
			header('Location: ../issue_med.php?status='.urlencode($status));
		}
	}

?>