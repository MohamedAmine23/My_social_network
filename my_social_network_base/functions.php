<?php
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