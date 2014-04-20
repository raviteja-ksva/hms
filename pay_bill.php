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

?>
<html>
<head>
<title>Bill Payment</title>
<h1> Bill Payment </h1>

<?php
    if(isset($_GET['error']))
    {
        $error = $_GET['error'];
        // echo $error . "<br/>" ;
        echo "<p style='color:red'> ".$error." </p>" ;
    }
?>

<?php
    if(isset($_GET['status']))
    {
    	$status = $_GET['status'];
       	echo '<script type="text/javascript"> alert("' .  $status .'"); </script>';
	}
?>


	<form action="includes/bill_pay.php" id="amb_service" method="POST">
	
		<div class="line">Patient Medical Registration number:
        	<input type="number" name="patient_id" id = "patient_id">
        </div>
	<div class="line submit"><input type="submit" value="Send" /></div>
	</form>
</body>
</html>