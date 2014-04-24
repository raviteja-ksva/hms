<?php

    // Inialize session
    session_start();

    // Check, if username session is NOT set then this page will jump to login page
    if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    }

    if ($_SESSION['type'] != "admin") {
        // $link  = $_SESSION['type'] . "_home.php";
        $redir  = "Location: " . $_SESSION['type'] . "_home.php";
        header($redir);
    }

    include('includes/config.inc');
    include('includes/functions.php');
  //  $username = get_username($_SESSION['userid'], $con);
    $is_valid_pat_id = 0;
?>

<?php 
    if(isset($_GET['amb_number'])) 
    { 
        $amb_number = $_GET['amb_number'];
        // echo "User Has submitted the form and entered this name : <b> $name </b>";
        // echo "<br>You can use the following form again to enter a new name."; 

        $query = "select avail_status from ambulance where amb_number = ?;" ;


        if ($stmt = $con->prepare($query)) {
            $stmt->bind_param('i', $amb_number);  // Bind "$patient_id" to parameter.
            $stmt->execute();
            $stmt->bind_result($avail_status);
            if ($stmt->fetch()) {
                //printf("%s, %s\n", $field1, $field2);
                    // echo $pat_name . "<br/>";
                    // echo $pat_add . "<br/>";
                    // echo $pat_phone . "<br/>";
                    // echo $pat_sex . "<br/>";
                    // echo $pat_dob . "<br/>";
                $is_valid_pat_id = 1;
            }
            else
            {
                $is_valid_pat_id = 0;
                echo "<p style='color:red'> Ambulance number does not exists </p>" ;
            }
            $stmt->close();
        }
    }

?>

<html>
    <head>
        <style type="text/css">
 
            body {font-family:Arial, Sans-Serif;}
 
            #container {width:300px; margin:0 auto;}
 
            /* Nicely lines up the labels. */
            form label {display:inline-block; width:140px;}
 
            /* You could add a class to all the input boxes instead, if you like. That would be safer, and more backwards-compatible */
            form input[type="text"]
 
            form .line {clear:both;}
            form .line.submit {text-align:left;}
 
        </style>
        <script src="includes/jquery.js"></script>
        <script type="text/javascript">
        $('document').ready(function(){
                //alert('dada');
                $('#amb_number_2').attr("type", "hidden");
                // var id=$('#patient_id_2').val();
                
                //alert(id);
        });
        </script>
    </head>
    <body>
    <?php
        if(isset($_GET['error']))
        {
            $error = $_GET['error'];
            echo $error . "<br/>" ;
            echo "<p style='color:red'> Incorrect details </p>" ;
        }
    ?>
        <div id="container">
<!-- <?php echo $is_valid_pat_id; ?> -->
            <h1>Edit Ambulance Details</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="GET" >                    
                <div class="line"><label for="amb_number">Ambulance Number: </label><input type="text" id="amb_number" name='amb_number' value="<?php if($is_valid_pat_id == 1) echo $amb_number; ?>"></div>
                <input type="submit" value="Go" />
            </form>
            <form action="includes/update_ambulance.php"  method="POST" >

               

                <div class="line">Available status:
                <input type="number" name="avail_status"  value="<?php if($is_valid_pat_id == 1)echo $avail_status; ?>">
                </div>

                

                <input type="text" name="amb_number_2" id='amb_number_2' value="<?php if($is_valid_pat_id == 1) echo $amb_number; ?>">

                <div class="line submit"><input type="submit" value="Edit" /></div>
    
                <p>Note: Please make sure your details are correct before submitting form.</p>
            </form>
            <form action= "home.php" method="POST">
  <!-- //  <input type="hidden" name="patient_id" id = "patient_id" value="<?php echo $patient_id; ?>"> -->
   <div class="line submit"><input type="submit" value="back to home page " /></div>
</form>
        </div>
    </body>
</html>