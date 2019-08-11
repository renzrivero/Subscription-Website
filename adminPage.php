<?php
    session_start();
    if(!isset($_SESSION["user_ID"]))
    {
        header("Location: index.php");
        $db->close();
        exit();
    }
    else
    {
        $db = new mysqli("localhost", "root", "30609278495705", "riveror");
        if ($db->connect_error)
        {
            die ("Connection failed: " . $db->connect_error);
        } 

        $user_ID = $_SESSION["user_ID"];
        $username = $_SESSION["username"];

        $q = "SELECT * FROM user WHERE NOT (user_ID ='7' AND username = 'admin')";
        $r = $db->query($q);
        $r5 = $db->query($q);

        $q1 = "SELECT programs.programName, subscribers.isSubbed, subscribers.user_ID
                FROM programs INNER JOIN subscribers
                ON programs.program_ID = subscribers.program_ID AND programs.user_ID";
                
        $r6 = $db->query($q1);

        if (isset($_POST["submitted"]) && $_POST["submitted"])
        {
            // Delete User
            $deleteUser = $_POST["deleteUser"];

            if ($deleteUser != "")
            {
                $searchUser = "SELECT * FROM user WHERE username = '$deleteUser'";
                $r1 = $db->query($searchUser);
                $row = $r1->fetch_assoc();
                $desiredID = $row["user_ID"];

                $deleteUserSubs = "DELETE FROM subscribers WHERE user_ID = '$desiredID'";
                $r2 = $db->query($deleteUserSubs);

                $deletePrograms = "DELETE FROM programs WHERE user_ID = '$desiredID'";
                $r3 = $db->query($deletePrograms);

                $deleteUserData = "DELETE FROM user WHERE user_ID = '$desiredID'";
                $r4 = $db->query($deleteUserData);

                header("Location: adminPage.php");
                $db->close();
                exit();
            }

            // Edit Password
            $currentPassword = $_POST["editPassword"];
            if ($currentPassword != "")
            {
                $_SESSION["currentPassword"] = $currentPassword;
                $_SESSION["username"] = $username;
                header("Location: adminEditPassword.php");
                $db->close();
                exit();
            }

            // Change Plans
            $response = $_POST["changePlans"];
            $program = substr($response, 0, 7);
            $responseLength = strlen($response);

            $program_ID = "";
            if ($program == "option1")
            {
                $program_ID = "1";
            }
            if ($program == "option2")
            {
                $program_ID = "2";
            }
            if ($program == "option3")
            {
                $program_ID = "3";
            }

            $operand = $response[7];

            $user_ID = substr($response, -2);

            if ($operand == "+")
            {
                $subscribeStatement = "UPDATE subscribers SET isSubbed = '1' WHERE user_ID = '$user_ID' AND program_ID = '$program_ID'";
                $r7 = $db->query($subscribeStatement);

                header("Location: adminPage.php");
                $db->close();
                exit();
            }

            if ($operand == "-")
            {
                $subscribeStatement = "UPDATE subscribers SET isSubbed = '0' WHERE user_ID = '$user_ID' AND program_ID = '$program_ID'";
                $r8 = $db->query($subscribeStatement);

                header("Location: adminPage.php");
                $db->close();
                exit();
            }

        }

        $db->close();
    }
?>

<html>

    <head>
        <title> Admin </title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>

    <body>
        <a id="signout" href="index.php"> Sign out </a> </br>
        <h1> Site Admin </h1>
        <form id="adminForm" method="post" action="adminPage.php">
        <input type="hidden" name="submitted" value="1"/>
            <div class="admin-grid-container">
                <div class="admin-grid-item">
                    <b> <u>Username</u> </b></br>
                    <?php
                        while ($row = $r->fetch_assoc())
                        {
                    ?>
                            <?php echo "<button value='" . $row["username"] . "' type='submit' name ='deleteUser'> - </button>" . "&ensp;" . $row["username"] . "</br></br></br>"; ?>
                    <?php
                        }
                    ?>
                </div>

                <div class="admin-grid-item">
                    <!-- the hyphen should change to a plus if a user has been added (ie. plus button under username is pressed) -->
                    <b> <u>Password</u> </b> </br>
                    <?php
                        while ($row1 = $r5->fetch_assoc())
                        {
                    ?>
                            <?php echo $row1["password"] . "&ensp; <button value='" . $row1["password"] . "' type='submit' name='editPassword'> Edit Password </button></br></br></br>";?>
                    <?php
                        }
                    ?>
                </div>

                <div class="admin-grid-item">
                    <!-- the hyphen should change into a textbox if a user has been added -->
                    <b> <u>Subscriptions</u> </b> </br>
                    <?php
                        while ($row2 = $r6->fetch_assoc())
                        {
                    ?>
                        <?php 
                            if ($row2["isSubbed"] == 1)
                            {

                                echo "<button value='" . $row2["programName"] .  "-" . $row2["user_ID"] . "' type='submit' name='changePlans'> - </button> &ensp;" . $row2["programName"] ."</br>";
                            }
                            else
                            {
                                echo "<button value='" . $row2["programName"] . "+" . $row2["user_ID"] . "' type='submit' name='changePlans'> + </button> &ensp;" . — . "</br>";
                            }
                        ?>
                    <?php
                        }
                    ?>
                </div>
            </div>

            <a href="adminAddUser.php"> Add a user here </a>
        </form>
    </body>



</html>