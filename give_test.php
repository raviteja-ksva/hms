<?php

	// Inialize session
	session_start();

	// Check, if username session is NOT set then this page will jump to login page
	if (!isset($_SESSION['userid'])) {
		header('Location: login.php');
	}

	if ($_SESSION['type'] != "doctor") {
		$redir  = "Location: " . $_SESSION['type'] . "_home.php";
	    header($redir);
	}
?>


<html>
    <head>
    <title>Lab Test</title>
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
        <div id="container">
            <form action="includes/write_test.php"  method="POST" id="lab_form" >
                <h1>Write Test</h1>

                <div class="line">Patient Medical Registration Number:
                <input type="number" name="patient_id" id="patient_id">
                </div>

                <?php
					// Creating query to fetch state information from mysql database table.
					mysql_connect("localhost","root","");
					mysql_select_db("hospital");
					$query = "select lt_id, lt_name from lab_teck;";
					$result = mysql_query($query);

					echo "Lab Teck:<br/>";
					echo '<select name="lt_id" id="lt_id" form="lab_form"> ';
					// echo '<option value=""> </option>';
					while ($row = mysql_fetch_array($result) )
					{
					   	echo '<option value="' .$row["lt_id"]. '">'.$row["lt_name"].'</option>';
					}
					echo "</select><br/>";

					$query = "select test_id, test_name from tests_info;";
					$result = mysql_query($query);
					echo "Test:<br/>";
					echo '<select name="test_id" id="test_id" form="lab_form"> ';
					// echo '<option value=""> </option>';
					while ($row = mysql_fetch_array($result) )
					{
					   	echo '<option value="' .$row["test_id"]. '">'.$row["test_name"].'</option>';
					}
					echo "</select><br/>";

				?>

                <div class="line">Test Date<input type="date" id="test_date" name='test_date'></div>
                <div class="line submit"><input type="submit" value="Submit" /></div>
 
            </form>
        <form action= "give_test.php" >
            <div class="line submit"><input type="submit" value="Another Test" /></div>
        </form>
        <form action= "doctor_home.php" >
            <div class="line submit"><input type="submit" value="Back to home page" /></div>
        </form>
        </div>
    </body>
</html>