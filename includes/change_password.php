<?php

	// Inialize session
	session_start();

	// Check, if username session is NOT set then this page will jump to login page
	if (!isset($_SESSION['userid'])) {
	header('Location: login.php');
	}

    // include('includes/config.inc');
    // include('includes/functions.php');
    // $username = get_username($_SESSION['userid'], $con);
    $usertype = $_SESSION['type'];
    $userid = $_SESSION['userid'];
    // $is_valid_pat_id = 0;
    // echo "Hello " . $username . "you can change your password here <br/>"; 

    $is_error=0;
    $errors="";

	if (isset($_POST['old_pass']) && !empty($_POST["old_pass"]))
	{
		// echo $_POST['username'];
	    $old_pass = $_POST["old_pass"];
	} else {
	    $errors .= 'Please enter your correct old password.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['new_pass']) && !empty($_POST["new_pass"]))
		$new_pass=$_POST['new_pass'];
	else {
	    $errors .= 'Please enter valid new password.<br/>';
	    $is_error = 1;
	}

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../chng_pass.php?error='.urlencode($msg));
	    echo $errors;
	}else {
		// select database and setup connection
		$con=mysql_connect('localhost','root','');
		if (!$con) {
	    	die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('hospital');

		$query = "SELECT password FROM hospital.login WHERE `user_id` = '$userid' and `type` = '$usertype';";
		// echo $query . "<br/>";
		$result = mysql_query($query);
		// echo $result;
		if($result)
		{	
			// echo $result;
			$row = mysql_fetch_array($result);
			$field1 = $row['password'];
			echo $field1;
	    	if($field1 == $old_pass)
	    	{
	    		$query2 = "UPDATE login SET `password`='$new_pass' WHERE `user_id`='$userid' and`type`='$usertype';";

				echo $query2;
				$result2 = mysql_query($query2);
				if($result2)
				{
					// echo $result2 . "<br/>";
					$status = "password updated successfull.";
					$redir  = "Location: ../" . $_SESSION['type'] . "_home.php?status=".urlencode($status);
					// echo $status;
					header($redir);
				} else{
					// echo $result2 . "<br/>";
					$status = "Please try again.";
					$redir  = "Location: ../chng_pass_home.php?status=".urlencode($status);
					// echo $status;
					header($redir);
				}
	    	} else{
				echo $result;
				$status = "Incorrect Password.\\nPlease try again.";
				$redir  = "Location: ../chng_pass.php?status=".urlencode($status);
				echo $status;
				header($redir);
			}
		}

		mysql_close($con);
	}
?>