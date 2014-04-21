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

	if(isset($_GET['status']))
    {
    	$status = $_GET['status'];
       	echo '<script type="text/javascript"> alert("' .  $status .'"); </script>';
		// header('Location: ../issue_med.php');       	
	}

	if (isset($_POST['patient_id']))
	{
	   	$patient_id = $_POST["patient_id"];
	} else {
	    $errors .= 'Please enter valid patient registration number.<br/>';
	    $is_error = 1;
	}

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../issue_med.php?error='.urlencode($msg));
	    echo $errors;
	}else
	{
		$con=mysql_connect('localhost','root','');
	    if (!$con) {
	        die('Could not connect: ' . mysql_error());
	    }
		mysql_select_db('hospital');

		$query = "select DISTINCT med_name from prescription where patient_id=$patient_id and pre_date = (select pre_date from prescription where patient_id=$patient_id order by pre_date DESC limit 1);";
		echo $query . "<br/>";

		$result = mysql_query($query);
		$rc = mysql_affected_rows();
		if($rc == 0)
		{
			$error = "Enter a vaild patient medical registration number";
	        header('Location: ../issue_med.php?error='.urlencode($error));
		}
	    echo "Records effected: " . $rc;
		echo "<p> Medicine </p>";
		echo '<select name="med_name" id="med_name" form="pres_med"> ';
		while ($row=   mysql_fetch_array($result) )
		{
		   echo "<option value='".$row["med_name"]."'>".$row["med_name"]."</option>";
		}
		echo "</select>";
	}

?>
	<form action="med_issue_2.php" id="pres_med" method="POST">
	
		<div class="line">Number:
        	<input type="number" name="num" id = "num" min="1">
        	<input type="hidden" name="patient_id" id='patient_id' value="<?php echo $patient_id; ?>">
        	<!-- <input type="hidden" name="patient_id" id = "patient_id" value="<?echo $patient_id; ?>"> -->
        </div>

	<div class="line submit"><input type="submit" value="Send" /></div>
	</form>

    <form action= "../home.php" >
        <div class="line submit"><input type="submit" value="Back to home page" /></div>
    </form>