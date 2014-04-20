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

	include('includes/config.inc');
    include('includes/functions.php');
    $username = get_username($_SESSION['userid'], $_SESSION['type'], $con);
    $is_valid_pat_id = 0;

?>
<html>
<head>
<title>Appointment</title>
<h1>Book an Apointment</h1>


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

<form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="GET" id="doctor_type" >
    <?php
	// Creating query to fetch state information from mysql database table.
	mysql_connect("localhost","root","");
	mysql_select_db("hospital");
	$query = "select DISTINCT type from doctor;";
	$result = mysql_query($query);

	echo "<p> Doctor Type </p>";
	echo "<select name='doc_type' id='doc_type'> ";
	while ($row = mysql_fetch_array($result) )
	{
	   	echo '<option value="' .$row["type"]. '">'.$row["type"].'</option>';
	}
	echo "</select>";

?>
    <div class="line submit"><input type="submit" value="Go" /></div>
</form>

<?php 
    if(isset($_GET['doc_type'])) 
    { 
    	mysql_connect("localhost","root","");
		mysql_select_db("hospital");
        $doc_type = $_GET['doc_type'];
		$query2 = "select doctor_id, doctor_name from doctor where type='$doc_type';";
		echo $query2 . "<br/>";
		$result2 = mysql_query($query2);
		// $rc = mysql_affected_rows();
        // echo "Records effected: " . $rc;
		echo "<p> Doctors </p>";
		echo "<select name='doc_id' id='doc_id' form='app_form'>";
		while ($row2 = mysql_fetch_array($result2))
		{	
		   	echo '<option value="' .$row2["doctor_id"]. '">'.$row2["doctor_name"].'</option>';
		}
		echo "</select>";
    }

?>


<html>
    <head>
        <style type="text/css">
 
            body {font-family:Arial, Sans-Serif;}
 
            #container {width:300px; margin:0 auto;}
 
            /* Nicely lines up the labels. */
            form label {display:inline-block; width:140px;}
 
            /* You could add a class to all the input boxes instead, if you like. That would be safer, and more backwards-compatible */
            form input[type="text"]
 
            form .line {clear:both;}
            form .line.submit {text-align:left;}
 
        </style>
    </head>
    <body>
    <?php
        if(isset($_GET['error']))
        {
            $error = $_GET['error'];
            echo $error . "<br/>" ;
            echo "<p style='color:red'> Incorrect details </p>" ;
        }
    ?>
    <div id="container">
        <form action="includes/assign_slot.php"  method="POST" id='app_form' >
            <div class="line">Patient Medical Registration Number
            <input type="number" name="patient_id" id="patient_id">
            </div>
            <div class="line">Date of Appointment<input type="date" id="app_date" name='app_date'></div>
            <div class="line submit"><input type="submit" value="Submit" /></div>

            <p>Note: Please make sure your details are correct before submitting form.</p>
        </form>
    </div>
    </body>
</html>
