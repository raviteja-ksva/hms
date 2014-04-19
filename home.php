<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) {
header('Location: login.php');
}

?>
<html>
	<head>
		<title>Home Page</title>
	</head>
	<body>

		<p>This is secured page with session: <b><?php echo $_SESSION['username']; ?></b>
		<br>You can put your restricted information here.</p>
		<p><a href="includes/logout.php">Logout</a></p>

	</body>
</html>