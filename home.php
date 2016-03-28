<?php
session_start();
include_once 'dbconnect.php';
include_once 'functions/functions.php';

if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}
userInfo();
?>
<!DOCTYPE html>
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
        <nav>
            <ul>
                <li>
                    <a href="upload.php">Add a Wish</a>
                </li>
                <li>
                    <a href="wishes.php?<?php echo $userRow['username']; ?>">Your Wishes</a>
                </li>
                <li>
                    <a href="wishlists.php?<?php echo $userRow['username']; ?>">Your Wishlists</a>
                </li>
            </ul>
        </nav>
        
        <?php
        
        echo "<h6>This is a test column, for the purpose of learning substr()</h6>";
        echo "<br>";
        echo substr($userRow['username'], 0, 2);
        echo substr($userRow['username'], -3). "<br>";
        echo UserHash(userInfo());
        ?>
    </body>
</html>