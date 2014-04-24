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
   // $username = get_username($_SESSION['userid'], $con);
    $is_valid_pat_id = 0;
?>

<?php 
    if(isset($_GET['lt_id'])) 
    { 
        $lt_id = $_GET['lt_id'];
        // echo "User Has submitted the form and entered this name : <b> $name </b>";
        // echo "<br>You can use the following form again to enter a new name."; 

        $query = "select lt_name, address, contact, dob, salery from lab_teck where lt_id = ?;" ;


        if ($stmt = $con->prepare($query)) {
            $stmt->bind_param('i', $lt_id);  // Bind "$patient_id" to parameter.
            $stmt->execute();
            $stmt->bind_result($lt_name, $lt_add, $lt_phone,  $lt_dob, $lt_salary);
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
                echo "<p style='color:red'> Nurse number does not exists </p>" ;
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
                $('#lt_id_2').attr("type", "hidden");
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
            <h1>Edit Lab Techinian Details</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="GET" >                    
                <div class="line">Lab teck Number:
                <input type="number" name="lt_id" value="<?php echo $lt_id; ?>">
                </div>
                <input type="submit" value="Go" />
            </form>
            <form action="includes/update_lab_teck.php"  method="POST" >

                <div class="line"><label for="lt_name">Lab teck Name: </label><input type="text" id="lt_name" name='lt_name' value="<?php if($is_valid_pat_id == 1) echo $lt_name; ?>"></div>
                <div class="line"><label for="lt_dob">Date Of Birth :</label><input type="date" id="lt_dob" name='lt_dob' value="<?php if($is_valid_pat_id == 1) echo $lt_dob; ?>"></div>

                <!-- Birthday: <input type="date" name="bday"> -->

                <div class="line"><label for="lt_add">Address: </label><textarea id="lt_add" name='lt_add'><?php if($is_valid_pat_id == 1) echo $lt_add; ?>
                </textarea></div>

                <div class="line">Contact Number:
                <input type="number" name="lt_phone" min="8000000000" max="9999999999" value="<?php if($is_valid_pat_id == 1)echo $lt_phone; ?>">
                </div>
                <div class="line">Salary:
                <input type="number" name="lt_salary"  value="<?php if($is_valid_pat_id == 1)echo $lt_salary; ?>">
                </div>
                
                

                <input type="number" name="lt_id_2" id='lt_id_2' value="<?php if($is_valid_pat_id == 1) echo $lt_id; ?>">

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