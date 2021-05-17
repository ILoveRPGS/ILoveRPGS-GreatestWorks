<?php

$host = 'samarium';
$user = '20savmit';
$pass = 'salasana';
$dbname = "20savmit";

try //yritetään ottaa yhteys
{ 
    $yhteys = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
    $user, $pass); 
    //luo PDO-olion
} 
catch(PDOException $e) // jos ei onnistu (poikkeus)
{ 
    echo $e->getMessage(); //antaa ilmoituksen siitä, missä virhe
}
?>