<?php
    require_once "functions.php";
    check_login();
    $pdo=connect();
    if(isset($_FILES['image']['name'])&&$_FILES['image']['name']!=''){
        if($_FILES['image']['error']==0){
            $typeOK=TRUE;
            if($_FILES['image']['type']=="image/gif"){
                $saveTo=$user.".gif";

            }
            else if ($_FILES['image']['type']=="image/gif"){
                $saveTo=$user.".gif";
            }
            else if($_FILES['image']['type']=="image/jpeg"){
                $saveTo=$user.".jpeg";
            }
            else if($_FILES['image']['type']=="image/png"){
                $saveTo=$user.".jpeg";
            }
            else{
                $typeOK=False;
                $error="mauvais type d'image :jpeg, png ou gif !";
            }
            if($typeOK){
                move_uploaded_file($_FILES['image']['tmp_name'],$saveTo);
                try{
                    $query=$pdo->prepare("UPDATE Members SET picture_path=:path WHERE pseudo=:pseudo");
                    $query->execute(array("path"=>$saveTo,"pseudo"=>$user));
                    $succes="Votre profil à été correctement mis a jour";
                    $picture_path=$saveTo;

                }catch(Exception $exc){
                    abort("Problème avec la base de données");
                    
                }
            }
        }else{
            $error="Probleme lors du chargement de l'image";
            
        }

    }
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
        abort("Erreur lors de l'acces à la base de données.");
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
        <?php include 'menu.html' ?>
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
            <?php if(isset($error)){?>
                <span class="error"><?=$error?></span>
            <?php } ?>
                
            
        </div>

    </body>
</html>