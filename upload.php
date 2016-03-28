<?php

include_once 'dbconnect.php';

session_start();
if(!isset($_SESSION['user']))
{
	header("Location: home.php");
}

$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
$wishlist_sql=mysql_query("SELECT wishlists.* FROM wishlists, users WHERE wishlists.user_id = ".$userRow['user_id']." AND users.user_id =".$userRow['user_id']);

if($wishlist_sql === FALSE) {
    die(mysql_error());
}
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
            <form action="" method="POST" enctype="multipart/form-data">
                <table align="center" width="40%" border="0">
                    <tr>
                        <td><label for="itemName">Item Name</label></td>
                        <td><input type="text" name="itemName" placeholder="Enter the name of your wish..." required /></td>
                    </tr>
                    <tr>
                        <td><label for="file">Upload an Image</label></td>
                        <td><input type="file" name="file"  required/></td>
                    </tr>
                    <tr>
                        <td><label for="description">Short Description</label></td>
                        <td><textarea name="description" rows="5" required></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="url">Item URL</label></td>
                        <td><input type="url" name="url" placeholder="http://" required/></td>
                    </tr>
                    <tr>
                        <td><label for="wishlists">Choose a wishlist</label></td>
                        <td>
                            <select name="wishlists">
                                <option selected="selected">Choose One:</option>
                                <?php
                                while($list = mysql_fetch_array($wishlist_sql))
                                    $lists[] = $list; 
                                foreach($lists as $list) {
                                    var_dump($list);
                                    $ename = $list['listName'];
                                    echo '<option value="'. $ename .'">'. $ename .'</option>';
                                }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="btn-upload" value="upload"></td>
                    </tr>
                </table>
            </form>
            
            <a href="home.php">Return Home</a> <br />
        </body>
    </html>
    
    <?php
            
            
            
            if(isset($_POST['btn-upload']))
            {
                //checking to see if folder directory exists, if not, creates it
                if(!file_exists($userRow['username']."/".date('Y')."/" .date('m'))) {
                    mkdir($userRow['username']."/".date('Y')."/" .date('m'), 0777, true);
                }
                //assigning variables to form post values
                $loc = $userRow['username']."/".date('Y')."/".date('m')."/";
                $itemName = mysql_real_escape_string($_POST['itemName']);
                $description = mysql_real_escape_string($_POST['description']);
                $url = mysql_real_escape_string($_POST['url']);
                $wishlist_name = mysql_real_escape_string($_POST['wishlists']);
                
                //executing query to grab wishlist_id from wishlist table
                $listid_sql = mysql_query("SELECT wishlists.* FROM `wishr`.`wishlists`, `users`
                                        WHERE wishlists.listName = '". $wishlist_name ."' AND users.user_id =". $userRow['user_id'] ." AND wishlists.user_id =" .$userRow['user_id']);
                $idRow = mysql_fetch_array($listid_sql);
                $wishlist_id = $idRow['list_id'];
                
                //testing query to make sure it is functioning properly, kill db and print error if returns FALSE
                if($listid_sql === FALSE) {
                    die(mysql_error());
                }
                
                if($_FILES["file"]["type"] == "image/png" || $_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/jpg" || $_FILES["file"]["type"] == "image/gif")
                {
                    
                    $files = explode(".", $_FILES["file"]["name"]);
                    $id = md5("$files[0]");
                    $newname = "$id.$files[1]";
                    $path = "$loc$newname";
                    
                    //this is just for testing purposes.
                        //echo"$file[0]<br>$file[1]";
                    
                    mysql_query("INSERT INTO wishes VALUES('','".$userRow['user_id']."','".$itemName."','".$description."','".$files[0]."','".$files[1]."','".$path."','".$url."', '".$wishlist_id."')");
                    
                    echo $path;
                    
                    move_uploaded_file($_FILES["file"]["tmp_name"], $path);
                    
                    echo "Your file has been successfully uploaded. Please <a href='$path'>Click here</a> to view your image!";
                    
                }
                else
                {
                    echo "invalid file type";
                }
                
            }
            ?>