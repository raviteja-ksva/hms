<?php
// Inialize session
session_start();

// Include database connection settings

//include('config.inc');
//require 'connect.php';

// Grab User submitted information
$errors = "";
$is_error = 0;

if (isset($_POST['username']))
{
	// echo $_POST['username'];
    $_POST["username"] = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    if ($_POST["username"] == "")
    {
        $errors .= 'Please enter a valid name.<br/><br/>';
        $is_error = 1;
    }
    else
    {
    	$name = $_POST["username"];
    	// echo $name ;
		// echo $errors;
    }
} else {
    $errors .= 'Please enter your name.<br/>';
    $is_error =1;
}

if (isset($_POST['dob']))
{
	$cur_date = date("Y-m-d");
	echo $cur_date . "<br>";
	$dob = $_POST['dob'];

	$datetime2 = new DateTime($cur_date);
	$datetime1 = new DateTime($dob);
	$interval = $datetime1->diff($datetime2);
	if($cur_date < $dob )
		echo "error...";
	else
		echo $interval->format('%R%a days');

}  else {
    echo 'Please enter your dob.<br/>';
}

if (isset($_POST['address']) && isset($_POST['phone_no'])&& isset($_POST['sex']))
{
	$address=$_POST['address'];
	$dob = $_POST['dob'];
	$phone_no=$_POST['phone_no'];
	$sex=$_POST['sex'];
}  else {
    echo 'Please enter your dob.<br/>';
}


// $con=mysql_connect('localhost','root','');
// mysql_select_db('hospital');

// $query="INSERT INTO patient (`patient_name`, `address`, `contact`, `sex`, `dob`) VALUES ('$name', '$address', '$phone_no', '$sex', '$dob');";
// echo $query;
// if(mysql_query($query))
// {

// 	echo 'inerted';
// }


?>