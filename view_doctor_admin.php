<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) {
header('Location: login.php');
}

// $redir = "Location: " . $_SESSION['type'] . "_home.php";
// header($redir);

 	if (($_SESSION['type'] != "admin")  ) {
 $redir = "Location: " . $_SESSION['type'] . "_home.php";
 header($redir);
 }
?>


<html>
<head>
<title>View Doctors</title>
<h1>Viwe Doctor</h1>
<?php
        if(isset($_GET['error']))
        {
            $error = $_GET['error'];
            echo $error . "<br/>" ;
            echo "<p style='color:red'> Incorrect details </p>" ;
        }
    ?>
<!-- <div id="container">
<form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id='app_form' >
<div class="line">Select Date<input type="date" id="app_date" name='app_date'></div>
<div class="line submit"><input type="submit" value="Submit" /></div>

<p>Note: Please make sure your details are correct before submitting form.</p>
</form>
</div> -->

<?php
     
     // $doc_id = $_SESSION['userid'];
     // $app_date = $_POST['app_date'];

     mysql_connect("localhost","root","");
mysql_select_db("hospital");
//$query = "select doctor_name, dob , address,contact, designation,type,appointment_charge,operation_charge from doctor ;";

$query =  "select t1.doctor_name, t1.dob , t1.address,t1.contact,t1.salary, t1.designation,t1.type,t2.start_time,t2.end_time,t1.appointment_charge,t1.operation_charge  from doctor as t1, doctor_slot as t2 where t1.doctor_id=t2.doctor_id ;";
//echo $query . "<br/>";
$result = mysql_query($query);

echo '<table border="1">';
echo '<tr><th>Doctor name</th><th>Date of birth</th><th>Address</th><th>Contact</th><th>Designation</th><th>Type</th><th>Appointment charge</th><th>Operation charge</th><th>Start time</th><th>End time</th></tr>';
while($row = mysql_fetch_assoc($result))
{
echo '<tr>';
echo '<td>'.$row['doctor_name'].'</td>';
echo '<td>'.$row['dob'].'</td>';
echo '<td>'.$row['address'].'</td>';
echo '<td>'.$row['contact'].'</td>';
echo '<td>'.$row['designation'].'</td>';
echo '<td>'.$row['type'].'</td>';
echo '<td>'.$row['appointment_charge'].'</td>';
echo '<td>'.$row['operation_charge'].'</td>';
echo '<td>'.$row['start_time'].'</td>';
echo '<td>'.$row['end_time'].'</td>';
echo '</tr>';
}
echo '</table> <br />';
     
    ?> 
 <form action="home.php" >
<div class="line submit"><input type="submit" value="Back to home page" /></div>
</form> 

</body>
</html>