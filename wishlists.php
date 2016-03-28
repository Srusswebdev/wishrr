<?php

session_start();
include_once 'dbconnect.php';
include_once 'functions/functions.php';

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
        <ul>
        <?php
        
        if(!isset($_SESSION['user']))
        {
            header("Location: index.php");
        }
        
        if(isset($_GET[$userRow['username']]))
        {
            
            
            $user_wishlists = mysql_query("SELECT wishlists.* FROM users, wishlists WHERE users.user_id=". $userRow['user_id'] ." AND wishlists.user_id=". $userRow['user_id']);
            
            if(!$user_wishlists === TRUE) {
                echo 'oops! there seems to be a problem with the server! -->'. mysql_error();
            }
            
            while($wishlists = mysql_fetch_array($user_wishlists))
            {
                echo '<li><a href="chelsraee/'. $wishlists['listName'] .'">'. $wishlists['listName'] .'</a></li>';
            }
            
            
            
            
        }
        else
        {
            echo "oops! Found a problem!"; mysql_error;
        }
        ?>
        </ul>
        <br />We're currently working on this feature. <a href="home.php">Return Home</a>
    </body>
</html>
-