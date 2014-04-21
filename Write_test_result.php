<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) {
header('Location: login.php');
}

if ($_SESSION['type'] != "lab_teck") {
    // $link  = $_SESSION['type'] . "_home.php";
    $redir  = "Location: " . $_SESSION['type'] . "_home.php";
    header($redir);
}

?>
<html>
<head>
<title>Lab result</title>
<h1> Lab Result Page </h1>

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


    <form action="includes/test_result.php" id="amb_service" method="POST">
    
        <div class="line">Test Transaction Number:
            <input type="number" name="test_tx_id" id = "test_tx_id">
            <div class="line"><label for="add"><h4>Result: </h4></label><textarea id="result" name='result'>
                </textarea></div>
        </div>
    <div class="line submit"><input type="submit" value="Send" /></div>
    </form>

</body>
</html>