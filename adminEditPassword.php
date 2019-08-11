<?php 
    $validate = true;
    $msg = "";
    $reg_Pswd = "/^(\S*)?\d+(\S*)?$/";
    session_start();
    if(!isset($_SESSION["currentPassword"]))
    {
        header("Location: adminPage.php");
        exit();
    }
    else
    {
        $db = new mysqli("localhost", "root", "30609278495705", "riveror");
        if ($db->connect_error)
        {
            die ("Connection failed: " . $db->connect_error);
        }   

        $username = $_SESSION["username"];
        $currentPassword = $_SESSION["currentPassword"];

        if (isset($_POST["submitted"]) && $_POST["submitted"])
        {
            $password = trim($_POST["password"]);

            $pswdLen = strlen($password);
            $pswdMatch = preg_match($reg_Pswd, $password);
            if($password == null || $password == "" || $pswdLen< 8 || $pswdMatch == false)
            {
                $validate = false;
            }

            if ($validate == true)
            {
                $changePasswordStatement = "UPDATE user SET password = '$password' WHERE password ='$currentPassword'";
                $r = $db->query($changePasswordStatement);
                header("Location: adminPage.php");
                $db->close();
                exit();
            }
        }
    }
?>

<html>
    <head>
        <title> Admin edit Password </title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script type="text/javascript" src="adminEditPassword.js"> </script>
    </head>

    <body>
        <h1> Edit Password </h1>
        <form id="signupForm" method="post" action="adminEditPassword.php">
        <input type="hidden" name="submitted" value="1"/>
            Current Password : <?php echo $currentPassword . "</br>";?>
            <label id="passwordMessage" class="errorMessage"></label>
            New Password: <input type="password" name="password"> <br>

            <input type="submit" value="Save Changes"> &ensp; <a href="adminPage.php"> >Back </a>
        </form>
        <script type="text/javascript" src="adminEditPasswordR.js"> </script>
    </body>
</html>