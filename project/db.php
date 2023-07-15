<?php
$dbhost = 'localhost';
$dbusername = 'SaeedMosaffer';
$dbuserpassword = 'saeedmosaffer';
$default_dbname = 'project';

try{
    $pdo = new PDO("mysql:host=$dbhost;dbname=$default_dbname",$dbusername,$dbuserpassword);
}catch(PDOException $e){
    die($e->getMessage());
}

?>