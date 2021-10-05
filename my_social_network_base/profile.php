<?php
    require_once "functions.php";
    if(isset($_GET["pseudo"])){
        $pseudo=sanitize($_GET["pseudo"]) ;
    }
    else{
        die("La page s'attend à recevoir un parametre 'pseudo' via la methode GET");
    }
    try{
       
        $query=$pdo->prepare("SELECT * FROM Members where pseudo = :pseudo");
        $query->execute(array("pseudo"=>$pseudo));
        $profile=$query->fetch();
        
    }
    catch(Exception $exc){
        die("Erreur lors de l'acces à la base de données.");
    }
    if($query->rowCount()==0){
        die("l'utilisateur n'existe pas ");
    }else{
        $description=$profile["profile"];
        $picture_path=$profile["picture_path"];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?=$pseudo ?>'s Profile!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title"><?=$pseudo ?>'s Profile!</div>
        <div class="menu">
            <a href="profile.php">Home</a>
            <a href="members.php">Members</a>
            <a href="friends.php">Friends</a>
            <a href="messages.php">Messages</a>
            <a href="edit_profile.php">Edit Profile</a>
            <a href="logout.php">Log Out</a>
        </div>
        <div class="main">
            <?php
                var_dump($profile);
                echo'<br><br>';
                var_dump($description);
                echo'<br><br>';
                var_dump($picture_path);
                echo'<br><br>';
                if(strlen($description)==0 ){
                    echo"No profile entered yet ! ";
                }else{
                    echo $description;
                }
            ?>
            <br><br>
            <?php
                if(strlen($picture_path)==0){
                    echo 'No picture yet !';

                }else{
                    echo "<image src='$picture_path' width='100' alt='$pseudo&apos;s photo!'>";
                }
            ?>
        </div>
    </body>
</html>
