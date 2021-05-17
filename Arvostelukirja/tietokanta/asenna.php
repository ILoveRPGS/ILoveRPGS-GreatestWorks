<!doctype html>
<html>
<head>
<title>Asennus</title>
<meta charset="utf-8">
</head>
<body>
<?php
require "./yhteys.php";

$sql="DROP TABLE IF EXISTS juttu";
$kysely = $yhteys->query($sql);
if($kysely!=FALSE) echo "Poistetaan vanhat juttu-taulut..<br>";

$sql="DROP TABLE IF EXISTS kayttaja";
$kysely = $yhteys->query($sql);
if($kysely) echo "Poistetaan vanhat kayttaja-taulut..<br>";

$sql="CREATE TABLE IF NOT EXISTS kayttaja(kid INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
sukunimi VARCHAR(30),
etunimi VARCHAR(30),
ktunnus VARCHAR(30),
saika DATE NOT NULL,
sposti VARCHAR(60),
salasana VARCHAR(100)) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci";
$kysely = $yhteys->query($sql);
if($kysely!=FALSE) echo "Taulu kayttaja lisätty!<br>";

$sql="CREATE TABLE IF NOT EXISTS juttu(jid INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
otsikko VARCHAR(100),
kpl TEXT,
poistamispvm DATE NOT NULL,
lisayspvm DATE, kid INT(6)) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci"; 
$kysely = $yhteys->query($sql);
if($kysely!=FALSE) echo "Taulu juttu lisätty!<br>";

$sql="ALTER TABLE juttu ADD CONSTRAINT vieras FOREIGN KEY (kid) REFERENCES kayttaja(kid)";
$kysely = $yhteys->query($sql);
if($kysely!=FALSE) echo "Vierasavain on lisätty!<br>";
?>
</body>
</html>