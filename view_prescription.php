<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) {
header('Location: login.php');
}

// $redir = "Location: " . $_SESSION['type'] . "_home.php";
// header($redir);

 	if (($_SESSION['type'] != "patient")  ) {
 $redir = "Location: " . $_SESSION['type'] . "_home.php";
 header($redir);
 }
  $repid = $_SESSION['userid'];
?>


<html>
<head>
<title>View Prescription</title>
<h1>View Prescrption</h1>
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
$query = "select pre_id, med_name , pre_date,morning, afternoon,night,no_days from prescription where patient_id= '$repid';";
//echo $query . "<br/>";
$result = mysql_query($query);

echo '<table border="1">';
echo '<tr><th>Prescription</th><th>Medicine name</th><th>Prescription date</th><th>Morning</th><th>Afternoon</th><th>Night</th><th>No of days</th></tr>';
while($row = mysql_fetch_assoc($result))
{
echo '<tr>';
echo '<td>'.$row['pre_id'].'</td>';
echo '<td>'.$row['med_name'].'</td>';
echo '<td>'.$row['pre_date'].'</td>';
echo '<td>'.$row['morning'].'</td>';
echo '<td>'.$row['afternoon'].'</td>';
echo '<td>'.$row['night'].'</td>';
echo '<td>'.$row['no_days'].'</td>';
echo '</tr>';
}
echo '</table> <br />';
     
    ?> 
 <form action="home.php" >
<div class="line submit"><input type="submit" value="Back to home page" /></div>
</form> 

</body>
</html>