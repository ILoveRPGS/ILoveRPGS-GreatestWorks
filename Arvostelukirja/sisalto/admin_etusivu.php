<?php
/* Ohjelma tulostaa yhden kirjoittajan jutut tietokannasta ja lisää jutun perään linkit "Muokkaa juttua" ja Poista juttu"*/

if(isset($_SESSION["arvostelijaID"])) $arvostelijaID=$_SESSION["arvostelijaID"];
$sql ="SELECT * FROM arvostelu 
INNER JOIN aiheet
ON aiheet.aiheID=arvostelu.aiheID
WHERE arvostelijaID='$arvostelijaID' ORDER BY kirjoitettu desc";
if($arvostelijaID==9){
    $sql ="SELECT * FROM arvostelu 
    INNER JOIN aiheet
    ON aiheet.aiheID=arvostelu.aiheID ORDER BY kirjoitettu desc";  
}

require "./tietokanta/yhteys.php";
$kysely=$yhteys->query($sql);

$rivit = $kysely->rowCount();
$vastaus = $kysely->fetchAll(PDO::FETCH_ASSOC); 
for($i=0;$i<$rivit;$i++) {
    $arvosteluID=$vastaus[$i]["arvosteluID"];
    $kirjoitettu=$vastaus[$i]["kirjoitettu"];
    $aiheID=$vastaus[$i]["aihenimi"];
    $otsikko=$vastaus[$i]["otsikko"];
    $arvostelijaID=$vastaus[$i]["arvostelijaID"];
    $kokonaisarvio=$vastaus[$i]["kokonaisarvio"];
    $aihe=$vastaus[$i]["aiheID"];

    $kirjoittajanimi=kayttajan_nimi($arvostelijaID,$yhteys);
    echo "<h1>".$otsikko."---".$aiheID."</h1>\n";
    echo "<p>".$kirjoittajanimi."---".$kirjoitettu."</p>";
    echo "<p>Annettu arvosana: ".$kokonaisarvio."/5</p>\n";
    echo "<a href=\"admin.php?sivu=muokkaa_juttua&arvosteluID=$arvosteluID&mode=muokkaa\">Muokkaa juttua </a><br>\n";
    echo "<a href=\"admin.php?sivu=muokkaa_juttua&arvosteluID=$arvosteluID&mode=poista\">Poista juttu</a><hr>\n";
} ?>