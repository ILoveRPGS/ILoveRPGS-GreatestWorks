<?php
/* Ohjelma tulostaa viisi viimeistä juttua tietokannasta */

$nyt=time();//hakee tämän hetken ajankohdan timestampin
$sql="SELECT * FROM arvostelu 
INNER JOIN aiheet
ON aiheet.aiheID=arvostelu.aiheID ORDER BY kirjoitettu desc";//date muuttaa timestampi mysql:n ymmärtämään muotoon

require "./tietokanta/yhteys.php";
$kysely=$yhteys->query($sql);

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
    $teksti=$vastaus[$i]["teksti"];

    $kirjoittajanimi=kayttajan_nimi($arvostelijaID,$yhteys);
    echo "<h1>".$otsikko."---".$aiheID."</h1>\n";
    echo "<p>".$kirjoittajanimi."---".$kirjoitettu."</p>";
    echo "<p>Annettu arvosana: ".$kokonaisarvio."/5</p>\n";
    echo "<p>".substr($teksti,0,100);
    echo " .... <a href=\"./index.php?sivu=juttu&arvosteluID=$arvosteluID\">Lue lisää</a></p>\n";
}
?>