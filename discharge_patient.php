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
<title>Discharging a patient</title>


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
    $query = "select patient_id, patient_name from patient;";
    $result = mysql_query($query);

    echo "<p> Patient </p>";
    echo "<select name='patient_id' id='patient_id' form='discharge_patient'> ";
    while ($row=   mysql_fetch_array($result) )
    {
        echo '<option value="' .$row["patient_id"]. '">'.$row["patient_name"].'</option>';
    }
    echo "</select>";
    
    $query = "select room_no from room where avail = '0';";
    $result = mysql_query($query);
    echo "<p> Room </p>";
    echo '<select name="room_no" id="room_no" form="discharge_patient"> ';
    while ($select_query_array=   mysql_fetch_array($result) )
    {
       echo "<option value='".$select_query_array["room_no"]."'>".$select_query_array["room_no"]."</option>";
    }
    echo "</select>";

    

?>

    <form action="includes/dis_patient.php" id="discharge_patient" method="POST">
        <div class="line submit"><input type="submit" value="Clear" /></div>
    </form>
    <form action= "home.php" method="POST">
  <!-- //  <input type="hidden" name="patient_id" id = "patient_id" value="<?php echo $patient_id; ?>"> -->
   <div class="line submit"><input type="submit" value="back to home page " /></div>
</form>
</body>
</html>