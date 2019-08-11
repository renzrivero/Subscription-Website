<?php
    session_start();
    $email = $_SESSION['email'];
    $hash = $_SESSION['hash'];
        
    $db = new mysqli("localhost", "root", "30609278495705", "riveror");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }

    $db->close();
?> 

<html>
    <title> Verify your Account! </title>
    <meta charset="utf-8"/>

    <a id="loginTopLeft" href="index.php"> Log in </a> </br>

    <h1> Please Verify your Account </h1>

    <body>
        Thank you for signing up! An email has been sent to <?php echo $email; ?> for account verification.
    </body>
</html>