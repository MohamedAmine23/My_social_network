<?php
require_once "functions.php";
$pseudo='';
$password='';
$password_confirm='';
if(isset($_POST["pseudo"])||isset($_POST['password'])||isset($_POST['password_confirm'])) {
    

    
    $pseudo=trim(sanitize(($_POST["pseudo"])));
    $password=(sanitize($_POST["password"]));
    $password_confirm=(sanitize($_POST["password_confirm"]));

    try{
        $query=$pdo->prepare("SELECT pseudo FROM members WHERE pseudo=:pseudo");
        $query->execute(array("pseudo"=>$pseudo));
        $row=$query->fetch();
        if($query->rowCount()==0){
            if(strlen($pseudo>=3)){
                
                
                if($password==$password_confirm){
                    $insert=$pdo->prepare("INSERT INTO members(pseudo,password) VALUES (:pseudo,:password");
                }else{
                    $error="les deux de mots de passe entrés doivent être identiques";
                }
            
            }else{
                $error="la taille du nom d'utilisateur est minimum 3 caractères";
            }
            
        }else {
            $error="le nom d'utilisateur existe déja";
        }
    }catch(Exception $exc){
        $error="ERREUR LORS DE L ACCES A LA BASE DE DONNEES";
    }
    

}


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Sign Up</div>
        <div class="menu">
            <a href="index.php">Home</a>
        </div>
        <div class="main">
            Please enter your details to sign up :
            <br><br>
            <form action="signup.php" method="post">
                <table>
                    <tr>
                        <td>Pseudo:</td>
                        <td><input id="pseudo" name="pseudo" type="text" value="<?=$pseudo?>"required></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input id="password" name="password" type="password" value="<?=$password?>" ></td>
                    </tr>
                    <tr>
                        <td>Confirm Password:</td>
                        <td><input id="password_confirm" name="password_confirm" type="password" value="<?=$password_confirm?>" ></td>
                    </tr>
                </table>
                <input type="submit" value="Sign Up">
            </form>
        </div>
        <?php 
            if(isset($error)){
                echo "<div class='errors'><br><br>$error</div>";
            }
        ?>
    </body>
</html>
