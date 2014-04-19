<!doctype html>
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
    </head>
    <body>
        <div id="container">
            <form action="includes/add_patient.php"  method="POST" >
                <h1>Register Patient</h1>
                <div class="line"><label for="username">Name: </label><input type="text" id="username" name='username'></div>
                <div class="line"><label for="dob">Date Of Birth :</label><input type="date" id="dob" name='dob'></div>

                <!-- Birthday: <input type="date" name="bday"> -->

                <div class="line"><label for="add">Address: </label><textarea id="address" name='address'>
                </textarea></div>

                <div class="line">Contact Number:
                <input type="number" name="phone_no" min="8000000000" max="9999999999">
                </div>

                <div class="line"><label for="username">Sex:</label><br></div>
                <input type="radio" name="sex" value="m">male
                <input type="radio" name="sex" value="f">Female

                <div class="line submit"><input type="submit" value="Submit" /></div>
 
                <p>Note: Please make sure your details are correct before submitting form.</p>
            </form>
        </div>
    </body>
</html>