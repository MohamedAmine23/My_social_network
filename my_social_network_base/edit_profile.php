<?php
    require_once "functions.php";
    check_login();
    
    try{
       
        if(isset($_POST['profile'])){
            $profile=sanitize($_POST['profile']);
            $update=$pdo->prepare("UPDATE Members SET profile =:profile WHERE pseudo =:pseudo");
            $update->execute(array("profile"=>$profile,"pseudo"=>$user));
            $succes="Votre profil a été correctement mis à jour ! ";
        }
        $query=$pdo->prepare("SELECT profile, picture_path FROM Members where pseudo = :pseudo");
        $query->execute(array("pseudo"=>$user));
        $row=$query->fetch();
        
    }
    catch(Exception $exc){
        die("Erreur lors de l'acces à la base de données.");
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?=$user ?>'s Profile</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Update Your Profile</div>
        <div class="menu">
            <a href="profile.php">Home</a>
            <a href="members.php">Members</a>
            <a href="friends.php">Friends</a>
            <a href="messages.php">Messages</a>
            <a href="edit_profile.php">Edit Profile</a>
            <a href="logout.php">Log Out</a>
        </div>
        <div class="main">
            <form method='post' action='edit_profile.php' enctype='multipart/form-data'>
                <p>Enter or edit your details and/or upload an image.</p>
                <textarea name='profile' cols='50' rows='3'><?=$row['profile'] ?></textarea><br><br>

                Image: <input type='file' name='image' accept="image/x-png, image/gif, image/jpeg"><br><br>
                <image src='<?=$row['picture_path'] ?>'><br><br>

                <input type='submit' value='Save Profile'>
            </form>
            <?php if(isset($succes)){?>
                <span class="success"><?=$succes?></span>
            <?php }?>
                
            
        </div>

    </body>
</html>

