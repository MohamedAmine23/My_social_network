<?php
session_start();
$dbhost="localhost";
$dbname="my_social_network_base";
$dbuser="root";
$dbpassword="root";

try{
    $pdo= new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8",$dbuser,$dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(Exception $exc){
    die("Erreur lors de la connexion à la base de données.");
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
