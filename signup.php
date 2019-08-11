<?php
    $validate = true;
    $msg = "";
    $reg_Username = "/^\w+$/";
    $reg_Email = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
    $reg_Pswd = "/^(\S*)?\d+(\S*)?$/";
    $email = "";
    
    if (isset($_POST["submitted"]) && $_POST["submitted"])
    {
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        
        $db = new mysqli("localhost", "root", "30609278495705", "riveror");
        if ($db->connect_error)
        {
            die ("Connection failed: " . $db->connect_error);
        }
        
        $q1 = "SELECT * FROM user WHERE email = '$email'";
        $r1 = $db->query($q1);
        
        $q2 = "SELECT * FROM user WHERE username = '$username'";
        $r2 = $db->query($q2);
        
        if($r1->num_rows > 0)
        {
            $msg = "The email address you've entered is already taken.";
            $validate = false;
        }
        else if ($r2->num_rows > 0)
        {
            $msg = "The user name you've entered is already taken.";
            $validate = false;
        }
        else
        {
            $usernameMatch = preg_match($reg_username, $username);
            if($username == null || $username == "" || $username == false)
            {
                $validate = false;
            }
            
            $emailMatch = preg_match($reg_Email, $email);
            if($email == null || $email == "" || $emailMatch == false)
            {
                $validate = false;
            }
            
            
            $pswdLen = strlen($password);
            $pswdMatch = preg_match($reg_Pswd, $password);
            if($password == null || $password == "" || $pswdLen< 8 || $pswdMatch == false)
            {
                $validate = false;
            }
        }
        
        if($validate == true)
        {
            $hash = md5(rand(0,1000));

            $to = $email;
            $subject = 'Signup | Verification';
            $message = '
            
            Thanks for signing up!
            Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
            
            ------------------------
            Username: '.$username.'
            Password: '.$password.'
            ------------------------
            
            Please click this link to activate your account:
            https://riveror.ursse.org/verifiedMessage.php?email='.$email.'&hash='.$hash.'
            
            ';
                                
            $headers = 'From:noreply@riveror.ursse.org' . "\r\n";
            mail($to, $subject, $message, $headers);

            $q3 = "INSERT INTO user (username, email, password, hash) VALUES ('$username', '$email', '$password', '$hash')";
            
            $r3 = $db->query($q3);

            if ($r3 === true)
            {
                $searchID = "SELECT * FROM user WHERE email = '$email' AND username = '$username'";
                $result = $db->query($searchID);
                $row = $result->fetch_assoc();
                $user_ID = $row["user_ID"];
                
                // Programs table
                $q4 = "INSERT INTO programs (user_ID, programName) VALUES ('$user_ID', 'option1')";
                $r4 = $db->query($q4);
    
                $q5 = "INSERT INTO programs (user_ID, programName) VALUES ('$user_ID', 'option2')";
                $r5 = $db->query($q5);
    
                $q6 = "INSERT INTO programs (user_ID, programName) VALUES ('$user_ID', 'option3')";
                $r6 = $db->query($q6);

                // Subscribers table
                $q7 = "INSERT INTO subscribers (program_ID, user_ID, isSubbed) VALUES ('1', '$user_ID', '0')";
                $r7 = $db->query($q7);
    
                $q8 = "INSERT INTO subscribers (program_ID, user_ID, isSubbed) VALUES ('2', '$user_ID', '0')";
                $r8 = $db->query($q8);
    
                $q9 = "INSERT INTO subscribers (program_ID, user_ID, isSubbed) VALUES ('3', '$user_ID', '0')";
                $r9 = $db->query($q9);

                session_start();
                $_SESSION["email"] = $email;
                $_SESSION["hash"] = $hash;
                header("Location: verifyAlert.php");
                $db->close();
                exit();
            }
        }
        else
        {
            $db->close();
        }
    }
?>

<html>
    <head>
        <title> Sign Up Page </title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script type="text/javascript" src="signup.js"> </script>
    </head>
    

    <body>
    <h1> Sign Up </h1>

        <p class="errorMessage"><?=$msg?></p>

        <form id="signupForm" method="post" action="signup.php">
            <input type="hidden" name="submitted" value="1"/>
                <label id="usernameMessage" class="errorMessage"></label>
                Username: <input type="text" name="username"> <br>
                
                <label id="passwordMessage" class="errorMessage"></label>
                Password: <input type="password" name="password"> <br>
                
                <label id="confirmPasswordMessage" class="errorMessage"></label>
                Confirm Password: <input type="password" name="confirmPassword"> <br>
            
                <label id="emailMessage" class="errorMessage"></label>
                Email: <input type="text" name="email"> <br>

                <label id="confirmEmailMessage" class="errorMessage"></label>
                Confirm Email: <input type="text" name="confirmEmail"> </br>

                Already have an account? <a id="login" href="index.php"> Log in here.</a> </br>
                
                <input id="createAccount" type="submit" value="Create Account">
        </form>

        <script type="text/javascript" src="signupR.js"> </script>

    </body>
</html>