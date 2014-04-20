<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) 
{
	header('Location: login.php');
}else {
	$redir  = "Location: " . $_SESSION['type'] . "_home.php";
    header($redir);
}
?>