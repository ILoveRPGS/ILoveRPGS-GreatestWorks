<?php
/* Ohjelma tulostaa yhden kirjoittajan jutut tietokannasta */

$arvostelijaID="";
if(isset($_GET["arvostelijaID"])) $arvostelijaID=$_GET["arvostelijaID"];
$nyt=time();
$sql="SELECT * FROM arvostelija WHERE arvostelijaID=? INNER JOIN aiheet
ON aiheet.aiheID=arvostelu.aiheID
WHERE arvostelijaID='$arvostelijaID' ORDER BY kirjoitettu desc";

if($arvostelijaID==9){
$sql="SELECT * FROM arvostelija WHERE arvostelijaID=? INNER JOIN aiheet
ON aiheet.aiheID=arvostelu.aiheID ORDER BY kirjoitettu desc";
}

require "./tietokanta/yhteys.php";
$kysely=$yhteys->prepare($sql);
$kysely->execute(array($arvostelijaID));

$rivit = $kysely->rowCount();
$vastaus = $kysely->fetchAll(PDO::FETCH_ASSOC); 
if($rivit<=5) $raja=$rivit;//jos rivejä on vähemmän kuin 5, tulostetaan todellinen määrä
else $raja=5;
for($i=0;$i<$raja;$i++) {
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
}
?>