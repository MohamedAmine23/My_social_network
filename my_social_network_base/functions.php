<?php
session_start();


function connect(){
    $dbhost = "localhost";
    $dbname = "my_social_network_base";
    $dbuser = "root";
    $dbpassword = "root";
    try {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", "$dbuser", "$dbpassword");//bug corrigé
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (Exception $exc) {
        abort("Erreur lors de la connexion à la base de données.");
    }
    
}

function is_pseudo_available($pseudo){
    $pdo=connect();
    try{
        $query=$pdo->prepare("SELECT * FROM Members WHERE pseudo=:pseudo");
        $query->execute(array("pseudo"=>$pseudo));
        $result=$query->fetchAll();
        return count($result)===0;
    }catch(Exception $exc){
        die("Probleme lors de l'acces a la base de données");
    }
}

function sanitize($var){
    $var=stripslashes($var);
    $var=strip_tags($var);
    $var=htmlspecialchars($var);
    return $var;
}

function redirect($url,$statusCode=303){
    header('Location: '.$url,true,$statusCode);
    die();
}

function check_login(){
    global $user;
    if(!isset($_SESSION['user']))
        redirect('index.php');
    else
        $user=$_SESSION['user'];
        

}
function my_hash($password){
    $prefixe_salt="VJemLnU3";
    $suffixe_salt="QUaLtRs7";
    return md5($prefixe_salt.$password.$suffixe_salt);

}
function check_password($password,$hash){
    return my_hash($password)==$hash;
}
function abort($err){
    global $error;
    $error=$err;
    include 'error.php';
    die;
}

function get_members(){
    $pdo=connect();
    try{
       
        $query=$pdo->prepare("SELECT pseudo FROM Members");
        $query->execute();
        return $query->fetchAll();
        
    }
    catch(Exception $exc){
        abort('Error while accessing the database. please contact your administrator.');
    }
}
function get_member($pseudo){
    $pdo=connect();
    try{
       
        $query=$pdo->prepare("SELECT * FROM Members where pseudo = :pseudo");
        $query->execute(array("pseudo"=>$pseudo));
        return $query->fetch();
        
    }
    catch(Exception $exc){
        abort("Erreur lors de l'acces à la base de données.");
    }
}
function update_member($pseudo){

}
function logout(){
    $_SESSION=array();
    session_destroy();
    redirect('index.php');
}
function  add_member($pseudo,$password){
    $pdo=connect();
        try{
            $query=$pdo->prepare("INSERT INTO Members(pseudo,password) VALUES(:pseudo,:password) ");
            $query->execute(array("pseudo"=>$pseudo,"password"=>my_hash($password) ));
            $_SESSION["user"]=$pseudo;
            redirect("profile.php");
        }catch(Exception $exc){
            abort("Probleme lors de l'acces a la base de données");
        }
}
function selection_filter($filter){
    $pdo=connect();
    try{
        $query=$pdo->prepare("SELECT * FROM Members WHERE pseudo LIKE :filter ");
        $query->execute(array("filter"=>$filter."%"));
        return $query->fetchAll();

    }catch (Exception $exc){
        die("erreur lors de l'acces a la base de données");
    }

}