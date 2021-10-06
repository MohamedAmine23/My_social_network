<?php
    require_once "functions.php";
   
    $pseudo='';
    $password='';
    if(isset($_POST['pseudo'])&&isset($_POST['password'])){
        $pseudo=sanitize($_POST['pseudo']);
        $password=sanitize($_POST['password']);

    
    try{
        $query=$pdo->prepare("SELECT password FROM members WHERE pseudo=:pseudo");
        $query->execute(array("pseudo"=> $pseudo));
        $user=$query->fetch();
        if($query->rowCount()!=0){
            if($password==$user['password']){
                redirect("profile.php?pseudo=$pseudo");
            }
            else{
                $error="Mauvais mot de passe, veuillez réessayer";
            }
        }
        else{
            $error="le pseudo \'$pseudo \' n\'existe pas. Inscrivez vous!";
        }
    }catch(Exception $exc){
        die('ERREURS LORS DE L ACCES A LA BASE DE DONNEES');
    }
    
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Log In</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Log In</div>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="signup.php">Sign Up</a>
        </div>
        <div class="main">
            <form action="login.php" method="post">
                <table>
                    <tr>
                        <td>Pseudo:</td>
                        <td><input id="pseudo" name="pseudo" type="text" value="<?=$pseudo ?>"></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input id="password" name="password" type="password" value="<?=$password?>"></td>
                    </tr>
                </table>
                <input type="submit" value="Log In">
            </form>
        </div>
        <?php 
            if(isset($error)){
                echo "<div class='errors'><br><br>$error</div>";
            }
        ?>
    </body>
</html>
