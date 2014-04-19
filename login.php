<?php

// Inialize session
session_start();

// Check, if user is already login, then jump to secured page
if (isset($_SESSION['userid'])) {
    $redir  = "Location: " . $_SESSION['type'] . "_home.php";
    header($redir);
    // header('Location: home.php');
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Login Form</title>

<script type="text/javascript" src = "../jquery.js"> </script>
<script type="text/javascript">
</script>
</head>
<body>
<?php
    if(isset($_GET['error']))
    {
        echo "<p style='color:red'> Incorrect Username or Password </p>";
    }
?>
    <form method="post" action="includes/validate_login.php" >
        <table border="1" >
            <tr>
                <td><label for="username">Username</label></td>
                <td><input type="text" 
                  name="username" id="username"></td>
            </tr>
            <tr>
                <td><label for="users_pass">Password</label></td>
                <td><input name="users_pass" 
                  type="password" id="users_pass"></input></td>
            </tr>
            <tr>
                <td><input type="submit" value="Submit"/>
                <td><input type="reset" value="Reset"/>
            </tr>
        </table>
    </form>
</body>
</html>