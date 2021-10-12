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
        $query=$pdo->prepare("SELECT * FROM Members WHERE psuedo=:pseudo");
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