<?php
require_once "functions.php";
$pseudo='';
$password='';
$password_confirm='';
if(isset($_POST["pseudo"])||isset($_POST['password'])||isset($_POST['password_confirm'])) {
    
    $pseudo=sanitize($_POST["pseudo"]);
    $password=sanitize($_POST["password"]);
    $password_confirm = sanitize($_POST["password_confirm"]);

    try{
        $query=$pdo->prepare("SELECT pseudo FROM members WHERE pseudo=:pseudo");
        $query->execute(array("pseudo"=>$pseudo));
        $row=$query->fetch();
        if($query->rowCount()!=0)
            $errors[]="le nom d'utilisateur existe déja";
     
            //precedement:       
        //tout se trouvait dans un seul try catch 
        // la notion  "d'erreurs multiple"
        // redirection et de connexion direct a la session 
        //query execute pour le insert
       
        
    }catch(Exception $exc){
        $error="ERREUR LORS DE L ACCES A LA BASE DE DONNEES";
    }
    if(trim($pseudo)=='')
        $errors[]="Le pseudo est obligatoire";
    if(strlen($pseudo)<3)
    $errors[]="la taille du nom d'utilisateur est minimum 3 caractères";
    if($password!=$password_confirm)
        $errors[]="les deux de mots de passe entrés doivent être identiques";
    if(!isset($errors)){
        try{
            $query=$pdo->prepare("INSERT INTO Members(pseudo,password) VALUES(:pseudo,:password) ");
            $query->execute(array("pseudo"=>$pseudo,"password"=>my_hash($password) ));
            $_SESSION["user"]=$pseudo;
            redirect("profile.php");
        }catch(Exception $exc){
            die("Probleme lors de l'acces a la base de données");
        }
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
            if(isset($errors)){
                echo "<div class='errors'><br><br><p>veuillez corriger les erreurs suivantes :</p><ul>";
                foreach($errors as $error){
                    echo "<li>$error</li>";
                }
                echo "</ul></div>";
            }
        ?>
    </body>
</html>
