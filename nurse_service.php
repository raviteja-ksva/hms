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
<title>Nurse Service</title>


</head>
<body>

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

<?php
	// Creating query to fetch state information from mysql database table.
	mysql_connect("localhost","root","");
	mysql_select_db("hospital");
	$query = "select nrs_id, nrs_name from nurse ;";
	$result = mysql_query($query);

	echo "<p> Nurse </p>";
	echo "<select name='nrs_id' id='nrs_id' form='nurse_service'> ";
	//echo "<select name='shift' id='shift' form='room_service'>";
	while ($row=   mysql_fetch_array($result) )
	{
	   	echo '<option value="' .$row["nrs_id"]. '">'.$row["nrs_name"].'</option>';
	}
	echo "</select>";

	$query = "select patient_id,patient_name  from patient ;";
	$result = mysql_query($query);
	echo "<p> Patient </p>";
	echo "<select name='patient_id' id='patient_id' form='nurse_service'> ";
	while ($select_query_array=   mysql_fetch_array($result) )
	{
	   echo "<option value='".$select_query_array["patient_id"]."'>".$select_query_array["patient_name"]."</option>";
	}
	echo "</select>";

?>

	<form action="includes/send_nurse.php" id="nurse_service" method="POST">
	
		
	<div class="line submit"><input type="submit" value="Send" /></div>
	</form>
</body>
</html>