<html>
<head>
<title>Drop Down</title>

<script>
  $(document).ready(function() {
    $("#driver_id").change(function(){
      $("#driver_id_2").val(("#driver_id").find(":selected").text());
    });
    $("#amb_number").change(function(){
      $("#amb_number_2").val(("#amb_number").find(":selected").text());
    });
  });
</script>

</head>
<body>

<?php
	// Creating query to fetch state information from mysql database table.
	mysql_connect("localhost","root","");
	mysql_select_db("hospital");
	$query = "select driver_id, driver_name from driver where avail = '1';";
	$result = mysql_query($query);

	echo "<p> Driver </p>";
	echo "<select name='driver_id' id='driver_id' form='amb_service'> ";
	while ($select_query_array=   mysql_fetch_array($result) )
	{
	   	echo '<option ="rav" >'.htmlspecialchars($select_query_array["driver_name"]).'</option>';
	}
	echo "</select>";
	echo '<input type="hidden" name="driver_id_2" id="driver_id_2">';

	$query = "select amb_number from ambulance where avail_status = '1';";
	$result = mysql_query($query);
	echo "<p> Ambulance </p>";
	echo "<select name='amb_number' id='amb_number' form='amb_service'> ";
	while ($select_query_array=   mysql_fetch_array($result) )
	{
	   echo "<option value='".htmlspecialchars($select_query_array["amb_number"])."' >".htmlspecialchars($select_query_array["amb_number"])."</option>";
	}
	echo "</select>";
	echo '<input type="hidden" name="amb_number_2" id="amb_number_2">'

?>

	<form action="includes/send_amb.php" id="amb_service" method="POST">
		<input type="number" name="patient_id" value="">

	<div class="line submit"><input type="submit" value="Send" /></div>
	</form>
</body>
</html>