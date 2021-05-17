<?php
/* Ohjelma tulostaa yhden jutun kannasta */

$arvosteluID="";
if(isset($_GET["arvosteluID"])) $arvosteluID=$_GET['arvosteluID'];

$sql="SELECT * FROM arvostelu 
INNER JOIN aiheet
ON aiheet.aiheID=arvostelu.aiheID
INNER JOIN arvostelija
ON arvostelija.arvostelijaID=arvostelu.arvostelijaID WHERE arvosteluID=?";

require "./tietokanta/yhteys.php";
$kysely=$yhteys->prepare($sql);
$kysely->execute(array($arvosteluID));

$rivi = $kysely->fetchAll(PDO::FETCH_ASSOC);

if(empty($rivi)) echo "Juttua ei löydy ";

else {
    $kirjoitettu=$rivi[0]["kirjoitettu"];
    $aiheID=$rivi[0]["aihenimi"];
    $otsikko=$rivi[0]["otsikko"];
    $kokonaisarvio=$rivi[0]["kokonaisarvio"];
    $teksti=$rivi[0]["teksti"];
    $arvostelijaID=$rivi[0]["arvostelijaID"];
    $kirjoittajannimi=kayttajan_nimi($arvostelijaID,$yhteys);

    echo "<h1>".$otsikko."</h1>\n";
    echo "<p>".$kirjoitettu."---".$aiheID."</p>";
    echo "<p>".$teksti."</p>";
    echo "<p>Annettu arvosana: ".$kokonaisarvio."/5 ---".$kirjoittajannimi."</p>\n";
}
?>