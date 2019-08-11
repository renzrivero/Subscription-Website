<?php
    $db = new mysqli("localhost", "root", "30609278495705", "riveror");

    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }

    $msg = "";

    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
    {
        $email = mysql_escape_string($_GET['email']);
        $hash = mysql_escape_string($_GET['hash']);
                     
        $q = "SELECT email, hash, active FROM user WHERE email='".$email."' AND hash='".$hash."' AND active='0'"; 
        $r = $db->query($q);
        $match = mysqli_num_rows($r);
                     
        if($match > 0)
        {
            // We have a match, activate the account
            $activateAccountQuery = "UPDATE user SET active='1' WHERE email='".$email."' AND hash='".$hash."' AND active='0'";
            $r1 = $db->query($activateAccountQuery);
            $msg = "Congratulations! Your account has been activated, you can now login";            
        }
        else
        {
            $msg = "The URL is either invalid or you already have activated your account.";
        }
                     
    }
    else
    {
        $msg = "Invalid approach. Please use the link that has been sent to your email";
    }

    $db->close();
?> 

<html>
    <head>
        <title> Account Verified </title>
        <meta charset="utf-8"/>
    </head>

    <a id="loginTopLeft" href="index.php"> Log in </a> </br>
    
    <body>
        <h1>
            <?php 
                echo $msg;
            ?>
        </h1>
    </body>
</html>