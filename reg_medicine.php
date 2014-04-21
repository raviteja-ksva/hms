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
// $username = get_username($_SESSION['userid'], $con);

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
            <form action="includes/add_medicine.php"  method="POST" >
                <h1>Add Medicine</h1>
                <div class="line"><label for="username">Medicine Name: </label><input type="text" id="username" name='username'></div>
                <div class="line"><label for="batchno">Batch no: </label><input type="number" id="batchno" name='batchno' min="0"></div>
                <div class="line"><label for="exp_date">Expiary date: </label><input type="date" id="exp_date" name='exp_date' ></div>
                <div class="line"><label for="stock">Stock: </label><input type="number" id="stock" name='stock' ></div>
               
                <!-- Birthday: <input type="date" name="bday"> -->


                <div class="line submit"><input type="submit" value="Submit" /></div>
 
                <p>Note: Please make sure your details are correct before submitting form.</p>
            </form>
        </div>
    </body>
</html>