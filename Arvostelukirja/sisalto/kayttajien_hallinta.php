<?php
require "./tietokanta/yhteys.php";
if(isset($_GET["arvostelijaID"])) $arvostelijaID=$_GET["arvostelijaID"];
$sql="SELECT * FROM arvostelija";
$kysely=$yhteys->query($sql);
$rivit = $kysely->rowCount();
$vastaus = $kysely->fetchAll(PDO::FETCH_ASSOC);
for($i=0;$i<$rivit;$i++) {
    $nimi=$vastaus[$i]["nimi"];
    $email=$vastaus[$i]["email"];
    $arvostelijaID=$vastaus[$i]["arvostelijaID"];
    $liittynyt=$vastaus[$i]["liittynyt"];

    echo "<h1>".$nimi."---ID on=".$arvostelijaID." <a href='./tietokanta/poista_kayttaja.php?id=" . $vastaus[$i]["arvostelijaID"]."'>Poista käyttäjä </a>"."</h1>\n";
    echo "<p>".$email."---".$liittynyt."</p>";
}
?>
<p>HUOM! Poista Ensin käyttäjän arvostelut niin voit poistaa käyttäjän!</p>