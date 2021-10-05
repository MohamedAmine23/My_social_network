<?php
    require_once "functions.php";
    try{
       
        $query=$pdo->prepare("SELECT pseudo FROM Members");
        $query->execute();
        $members=$query->fetchAll();
        var_dump($members);
    }
    catch(Exception $exc){
        die('Error while accessing the database. please contact your administrator.');
    }
    
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Members</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        
        <div class="title">Other Members</div>
        <div class="menu">
            <a href="profile.php">Home</a>
            <a href="members.php">Members</a>
            <a href="friends.php">Friends</a>
            <a href="messages.php">Messages</a>
            <a href="edit_profile.php">Edit Profile</a>
            <a href="logout.php">Log Out</a>
        </div>
        <div class="main">
       
            <ul>
                <?php foreach($members as $member){?>
                        <li>
                            <a href="profile.php?pseudo=<?=$member['pseudo']?>"><?=$member['pseudo'] ?></a>
                        </li>
                <?php }?>
            </ul>
            
        </div>
    </body>
</html>