<?php
    require_once "functions.php";
    check_login();
   
    if(isset($_GET["pseudo"])){
        $pseudo=sanitize($_GET["pseudo"]) ;
    }
    else{
        $pseudo=$user;
    }
    $profile=get_member($pseudo);
    if(count($profile)==0){
        abort("l'utilisateur n'existe pas ");
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
        <?php include 'menu.html' ?>
        <div class="main">
            <?php        
    
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
