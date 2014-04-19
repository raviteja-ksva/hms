<html>
<head>
<title>Drop Down</title>
</head>
<body>

<?php
	// Creating query to fetch state information from mysql database table.
	mysql_connect("localhost","root","");
	mysql_select_db("hospital");
	$query = "select * from driver where avail = '1';";
	$result = mysql_query($query);

	echo "<select name='category'> Driver";
	while ($select_query_array=   mysql_fetch_array($result) )
	{
	   echo "<option value='' >".htmlspecialchars($select_query_array["type"])."</option>";
	}
	echo "</select>";

?>
</body>
</html>