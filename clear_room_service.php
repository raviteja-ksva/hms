<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) {
header('Location: login.php');
}

if ($_SESSION['type'] != "rep") {
    // $link  = $_SESSION['type'] . "_home.php";
    $redir  = "Location: " . $_SESSION['type'] . "_home.php";
    header($redir);
}

?>

<html>
<head>
<title>Room service clear</title>


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

<?php
    // Creating query to fetch state information from mysql database table.
    mysql_connect("localhost","root","");
    mysql_select_db("hospital");
    $query = "select wb_id, wb_name from ward_boy where avail = '0';";
    $result = mysql_query($query);

    echo "<p> Ward boy </p>";
    echo "<select name='wb_id' id='wb_id' form='room_service'> ";
    while ($row=   mysql_fetch_array($result) )
    {
        echo '<option value="' .$row["wb_id"]. '">'.$row["wb_name"].'</option>';
    }
    echo "</select>";
    
    $query = "select room_no from room;";
    $result = mysql_query($query);
    echo "<p> Room </p>";
    echo '<select name="room_no" id="room_no" form="room_service"> ';
    while ($select_query_array=   mysql_fetch_array($result) )
    {
       echo "<option value='".$select_query_array["room_no"]."'>".$select_query_array["room_no"]."</option>";
    }
    echo "</select>";

?>

    <form action="includes/clear_room.php" id="room_service" method="POST">
        <div class="line submit"><input type="submit" value="Clear" /></div>
    </form>

<form action= "home.php" method="POST">
  <!-- //  <input type="hidden" name="patient_id" id = "patient_id" value="<?php echo $patient_id; ?>"> -->
   <div class="line submit"><input type="submit" value="back to home page " /></div>
</form>
    
</body>
</html>