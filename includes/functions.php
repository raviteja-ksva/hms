<?php


function validate_login($username, $pass, $con){

	$query = 'SELECT user_id, password, type FROM hospital.login WHERE user_name = ? LIMIT 1';
	// echo $query;

	if ($stmt = $con->prepare($query)) {
		$stmt->bind_param('s', $username);  // Bind "$username" to parameter.
	    $stmt->execute();
	    $stmt->bind_result($field1, $field2, $field3);
	    if($stmt->fetch()) {
	        // printf("%s, %s\n", $field1, $field2);
	        if($field2==$pass){
			    // echo $username . ", you are a validated user.";
			    $_SESSION['userid'] = $field1;
			    $_SESSION['type'] = $field3;
			    // $redir = $field3 . "_home.php";
			    return true;
	        }
			else{
			    echo '<script type="text/javascript"> alert("Sorry, wrong username and password") ; </script>';
			    header('Location: login.php'); // Jump to login page
			}
	    }
	    else {
	    	echo '<script type="text/javascript"> alert("username does not exists"); </script>';
	    	// header('Location: login.php'); // Jump to login page
	    	return false;
	    }
	    $stmt->close();
	}

}

function get_username($userid, $con)
{
	$query = 'SELECT user_name FROM hospital.login WHERE user_id = ? LIMIT 1';
	if ($stmt = $con->prepare($query)) {
		$stmt->bind_param('i', $userid);  // Bind "$username" to parameter.
	    $stmt->execute();
	    $stmt->bind_result($field1);
	    if($stmt->fetch()) {
	        // printf("%s, %s\n", $field1, $field2);
	    	return $field1;
	    }
	    $stmt->close();
	}
}

?>