<?php
    session_start();
    if(!isset($_SESSION["user_ID"]))
    {
        header("Location: index.php");
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
        $option1Value = "Subscribe";
        $option2Value = "Subscribe";
        $option3Value = "Subscribe";

        $q = "SELECT * FROM subscribers WHERE user_ID = '$user_ID'"; 
        $r = $db->query($q);

        if (isset($_POST["submitted"]) && $_POST["submitted"])
        {        
            // POST VALUES
            // $btnOneValue = trim($_POST["program1"]);
            // $btnTwoValue = trim($_POST["program2"]);
            // $btnThreeValue = trim($_POST["program3"]);
            $btnPressedValue = "";
            if (isset($_POST["program1"]))
            {
                $btnPressedValue = trim($_POST["program1"]);
                if ($btnPressedValue == "Subscribe")
                {
                    $q = "UPDATE subscribers SET isSubbed='1' WHERE program_ID = '1' AND user_ID ='$user_ID'";
                    $r = $db->query($q);
                    header("Location: main.php");
                    exit();
                }
                else
                {
                    $q = "UPDATE subscribers SET isSubbed='0' WHERE program_ID = '1' AND user_ID ='$user_ID'";
                    $r = $db->query($q);
                    header("Location: main.php");
                    exit();
                }
            }

            if (isset($_POST["program2"]))
            {
                $btnPressedValue = trim($_POST["program2"]);
                if ($btnPressedValue == "Subscribe")
                {
                    $q = "UPDATE subscribers SET isSubbed='1' WHERE program_ID = '2' AND user_ID ='$user_ID'";
                    $r = $db->query($q);
                    header("Location: main.php");
                    exit();
                }
                else
                {
                    $q = "UPDATE subscribers SET isSubbed='0' WHERE program_ID = '2' AND user_ID ='$user_ID'";
                    $r = $db->query($q);
                    header("Location: main.php");
                    exit();
                }
            }

            if (isset($_POST["program3"]))
            {
                $btnPressedValue = trim($_POST["program3"]);
                if ($btnPressedValue == "Subscribe")
                {
                    $q = "UPDATE subscribers SET isSubbed='1' WHERE program_ID = '3' AND user_ID ='$user_ID'";
                    $r = $db->query($q);
                    header("Location: main.php");
                    exit();
                }
                else
                {
                    $q = "UPDATE subscribers SET isSubbed='0' WHERE program_ID = '3' AND user_ID ='$user_ID'";
                    $r = $db->query($q);
                    header("Location: main.php");
                    exit();
                }
            }

            $db->close();
        }

    }
?> 

<html>
    <head>
        <title> Someones's Subscriptions </title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script type="text/javascript" src="main.js"> </script>
    </head>

    <body>
        <a id="signout" href="index.php"> Sign out </a> </br>

        <h1> Your Subscriptions </h1>
        <?php
            while($row = $r->fetch_assoc())
            {
                $msg =""; 
                if ($row["isSubbed"] == 1)
                {
                    if ($row["program_ID"] == 1)
                    {
                        $msg = "<li> Option 1 </li>";
                        $option1Value = "Unsubscribe";
                    }
                    if ($row["program_ID"] == 2)
                    {
                        $msg = "<li> Option 2 </li>";
                        $option2Value = "Unsubscribe";
                    }
                    if ($row["program_ID"] == 3)
                    {
                        $msg = "<li> Option 3 </li>";
                        $option3Value = "Unsubscribe";
                    }
                }
        ?>    
            <?php echo "<ul>".$msg."</ul>"; ?>
        <?php
            }
        ?>

        <b> Below are all the programs you have access to. Click on each badge to subscribe/unsubscribe or learn more.</b>
        
        <form id="mainForm" method="post" action="main.php">
            <input type="hidden" name="submitted" value="1"/>
            <div class="grid-container">
                <div id="programs">

                    <div id="option1" class="grid-item">
                        <h1>  Option 1 </h1>
                        <input id="program1" type="submit" value="<?php echo $option1Value;?>" name="program1">
                    </div>
                
                    <div id="option2" class="grid-item">
                        <h1> Option 2 </h1>
                        <input id="program2" type="submit" value="<?php echo $option2Value;?>" name="program2">
                    </div>

                    <div id="option3" class="grid-item">
                        <h1> Option 3 </h1>
                        <input id="program3" type="submit" value="<?php echo $option3Value;?>" name="program3">
                    </div>
                </div>
            </div>
        </form>

        <script type="text/javascript" src="mainR.js"> </script>
    </body>
</html>