<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) {
header('Location: login.php');
}

if ($_SESSION['type'] != "admin") {
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
            <form action="includes/add_room.php"  method="POST" >
                <h1>Register Room</h1>
             
               <div class="line"><label for="room_no">Room Number: </label><input type="number" id="room_no" name='room_no' min="0"></div>
                <div class="line"><label for="room_type">Room Type: </label><input type="text" id="room_type" name='room_type' ></div>
                   <div class="line">Availability:</label><br></div>
                <input type="radio" name="avail" value="1">Yes
                <input type="radio" name="avail" value="0">No
                 

                <div class="line submit"><input type="submit" value="Submit" /></div>
 
                <p>Note: Please make sure your details are correct before submitting form.</p>
            </form>
        </div>
    </body>
</html>