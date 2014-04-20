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
            <form action="includes/add_doctor.php"  method="POST" >
                <h1>Register Doctor</h1>
                <div class="line"><label for="username">Name: </label><input type="text" id="username" name='username'></div>
                <div class="line"><label for="age">Age: </label><input type="number" id="age" name='age' min="0"></div>
                <div class="line"><label for="salary">Salary: </label><input type="number" id="salary" name='salary' min="0"></div>
                <div class="line"><label for="designation">Designation: </label><input type="text" id="designation" name='designation'></div>
                <div class="line"><label for="type">Type: </label><input type="text" id="type" name='type' ></div>
                <div class="line"><label for="appointment_charge">Appointment charge: </label><input type="number" id="appointment_charge" name='appointment_charge' min="0"></div>
                <div class="line"><label for="operation_charge">Operation charge: </label><input type="number" id="operation_charge" name='operation_charge' min="0"></div>
                <div class="line"><label for="dob">Date Of Birth :</label><input type="date" id="dob" name='dob'></div>

                <!-- Birthday: <input type="date" name="bday"> -->

                <div class="line"><label for="address">Address: </label><textarea id="address" name='address'>
                </textarea></div>

                <div class="line">Contact Number:
                <input type="number" name="phone_no" min="8000000000" max="9999999999">
                </div>
<!-- 
                <div class="line"><label for="username">Sex:</label><br></div>
                <input type="radio" name="sex" value="m">male
                <input type="radio" name="sex" value="f">Female -->

                <div class="line submit"><input type="submit" value="Submit" /></div>
 
                <p>Note: Please make sure you entered correct details  before submitting form.</p>
            </form>
        </div>
    </body>
</html>