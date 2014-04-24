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
<title>Allocate room</title>


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
	$query = "select room_no from room where avail = '1';";
	$result = mysql_query($query);

	$query = "select patient_id, patient_name from patient where  patient_id not in (select patient_id from admission where discharge_date is NULL)  ;";
	$result = mysql_query($query);


	echo "<p> Patient </p>";
	echo "<select name='patient_id' id='patient_id' form='allocate_room'> ";
	while ($row=   mysql_fetch_array($result) )
	{
	   	echo '<option value="' .$row["patient_id"]. '">'.$row["patient_name"].'</option>';
	}

	echo "</select>";

?>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="GET" id="rooms_type" >
    <?php
	// Creating query to fetch state information from mysql database table.
	mysql_connect("localhost","root","");
	mysql_select_db("hospital");
	$query = "select DISTINCT room_type from room_type;";
	$result = mysql_query($query);

	echo "<p> Room Type </p>";
	echo "<select name='room_type' id='room_type'> ";
	while ($row = mysql_fetch_array($result) )
	{
	   	echo '<option value="' .$row["room_type"]. '">'.$row["room_type"].'</option>';
	}
	echo "</select>";

?>
    <div class="line submit"><input type="submit" value="Go" /></div>
</form>

<?php 
    if(isset($_GET['room_type'])) 
    {
    	mysql_connect("localhost","root","");
		mysql_select_db("hospital");

        $room_type = $_GET['room_type'];
		$query2 = "select room_no from room where room_type='$room_type';";

		echo $query2 . "<br/>";
		$result2 = mysql_query($query2);
		// $rc = mysql_affected_rows();
        // echo "Records effected: " . $rc;
	echo "<p> Room Nos </p>";
	echo "<select name='room_no' id='room_no' form='allocate_room'> ";
	while ($row=   mysql_fetch_array($result2) )
	{
	   	echo '<option value="' .$row["room_no"]. '">'.$row["room_no"].'</option>';
	}
	echo "</select>";
    }



?>


	<form action="includes/alloc_room.php" id="allocate_room" method="POST">
	
		
	<div class="line submit"><input type="submit" value="Send" /></div>
	</form>

<form action= "home.php" method="POST">
  <!-- //  <input type="hidden" name="patient_id" id = "patient_id" value="<?php echo $patient_id; ?>"> -->
   <div class="line submit"><input type="submit" value="back to home page " /></div>
</form>


</body>
</html>