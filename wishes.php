<?php

session_start();
include_once 'dbconnect.php';
include_once 'functions/functions.php'

?>

<html>
    <head>
        <meta http-equiv="Content-Type:" content="text/html" charset="utf-8" />
        <title>Welcome - <?php echo $userRow['username']; ?></title>
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>
    <body>
        <div id="header">
            <div id="left">
                <label>Wishr.</label>
            </div>
            <div id="right">
                <div id="content">
                    hi' <?php echo $userRow['username']; ?>&nbsp;<a href="logout.php?logout">Sign out</a>
                </div>
            </div>
        </div>
        <h1><?php echo $userRow['username']; ?>'s Wishlist.</h1>
        
        <?php
        
        if(!isset($_SESSION['user']))
        {
            header("Location: index.php");
        }
        
        if(isset($_GET[$userRow['username']]))
        {
            
            
            $user_wishes = mysql_query("SELECT wishes.imgLocation, wishes.user_id, users.username FROM `wishes`,users WHERE wishes.user_id=".$userRow['user_id']." AND users.user_id=".$userRow['user_id']);
            
            while($wishes = mysql_fetch_array($user_wishes))
            {
                echo '<a href="'.$wishes['imgLocation'].'"><img src="'.$wishes['imgLocation'].'" height="300px" width="auto" /></a>';
            }
            
            
            
            
        }
        else
        {
            echo "oops! Found a problem!"; mysql_error;
        }
        ?>
        
        <br />We're currently working on this feature. <a href="home.php">Return Home</a>
    </body>
</html>
