<?php

    // Inialize session
    session_start();

    // Check, if username session is NOT set then this page will jump to login page
    if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    }

    include('includes/config.inc');
    include('includes/functions.php');
    $username = get_username($_SESSION['userid'],$_SESSION['type'], $con);
    // $usertype = $_SESSION['type'];
    // $userid = $_SESSION['userid'];
    // $is_valid_pat_id = 0;
    echo "<h3
    >Hello " . $username . ", you can change your password here <br/></h3>"; 
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
    <?php
        if(isset($_GET['error']))
        {
            $error = $_GET['error'];
            echo $error . "<br/>" ;
            echo "<p style='color:red'>".$error."</p>" ;
        }
    ?>
        <div id="container">
            <form action="includes/change_password.php"  method="POST" >

                <table border="2" >
                    <tr>
                        <td><label for="users_pass">Old Password</label></td>
                        <td><input name="old_pass" 
                          type="password" id="old_pass"></input></td>
                    </tr>
                    <tr>
                        <td><label for="users_pass">New Password</label></td>
                        <td><input name="new_pass" 
                          type="password" id="new_pass"></input></td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Submit"/>
                        <td><input type="reset" value="Reset"/>
                    </tr>
                </table>
    
                <p>Note: Please make sure your details are correct before submitting form.</p>
            </form>
        </div>
    </body>
</html>