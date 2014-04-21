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

	include('includes/config.inc');
    include('includes/functions.php');
    $username = get_username($_SESSION['userid'], $_SESSION['type'], $con);
    // $is_valid_pat_id = 0;

?>

<html>
<head>
<title>Medicine</title>
<h1>Issue Medicine</h1>


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

    <div id="container">
        <form action="includes/med_issue.php"  method="POST" id='app_form' >
            <div class="line">Patient Medical Registration Number
            <input type="number" name="patient_id" id="patient_id">
            </div>
           <!--  <div class="line">Date of Prescription<input type="date" id="app_date" name='app_date'></div> -->
            <div class="line submit"><input type="submit" value="Go" /></div>

            <p>Note: Please make sure your details are correct before submitting form.</p>
        </form>

    <form action= "home.php" >
        <div class="line submit"><input type="submit" value="Back to home page" /></div>
    </form>
    </div>
    </body>
</html>
