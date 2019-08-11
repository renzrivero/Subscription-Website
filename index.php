<?php
    $db = new mysqli("localhost", "root", "30609278495705", "riveror");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }

    $validate = true;
    $reg_Username = "/^\w+$/";
    $reg_Pswd = "/^(\S*)?\d+(\S*)?$/";
    
    $username = "";
    $error = "";
    
    if (isset($_POST["submitted"]) && $_POST["submitted"])
    {
        $username = trim($_POST["loginUsername"]);
        $password = trim($_POST["loginPassword"]);
        
        $db = new mysqli("localhost", "root", "30609278495705", "riveror");
        if ($db->connect_error)
        {
            die ("Connection failed: " . $db->connect_error);
        }
    
        $q = "SELECT * from user WHERE username = '$username' AND password = '$password'";
         
        $r = $db->query($q);
        $row = $r->fetch_assoc();
        if($username != $row["username"] && $password != $row["password"] && $row["active"] == 0)
        {
            $validate = false;
            $error = "Please verify your account before you can log in";
        }
        else
        {
            $usernameMatch = preg_match($reg_Username, $username);
            if($username == null || $username == "" || $usernameMatch == false)
            {
                $validate = false;
                $error = "Username not found. Try again or create an account!";
            }
            
            $pswdLen = strlen($password);
            $passwordMatch = preg_match($reg_Pswd, $password);
            if($password == null || $password == "" || $pswdLen < 8 || $passwordMatch == false)
            {
                $validate = false;
                $error = "Wrong password. Try again!";
            }

            $verified = 1;
            if ($verified != $row["active"])
            {
                $validate = false;
                $error = "Please verify your account before you can log in.";
            }
        }
        
        if($validate == true)
        {
            session_start();
            $_SESSION["user_ID"] = $row["user_ID"];
            $_SESSION["username"] = $row["username"];
            if ($row["username"] == "admin")
            {
                header("Location: adminPage.php");
                $db->close();
                exit();
            }
            header("Location: main.php");
            $db->close();
            exit();
        }
        else 
        {
            $db->close();
        }
    }
?>

<html>
    <head>
        <title> ENSE 353 Assignment # 4 </title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script type="text/javascript" src="login.js"> </script>
    </head>
    

    <body>
        <h1> ENSE 353 Assignment # 4</h1> </br>

        <form id="loginForm" method="post" action="index.php">
            <input type="hidden" name="submitted" value="1"/>
            
            <label id="usernameMessageLogin" class="errorMessage"></label>
            Username: <input type="text" name="loginUsername"></br>
            
            <label id="passwordMessageLogin" class="errorMessage"></label>
            Password: <input type="password" name="loginPassword"></br>

            <div class="errorMessage"> <?php echo $error ?></div>
            
            Don't have an account? <a id="signup" href="signup.php"> Sign up here.</a></br>

            <input type="submit" value="Log In"/>
        </form>

        <script type="text/javascript" type="submit" src="loginR.js"> </script>
    </body>
</html>