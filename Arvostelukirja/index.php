<?php
$sivu="etusivu";
if(isset($_GET["sivu"])) $sivu=$_GET["sivu"];

require "./kirjastot/funktiot.php";//ulkoasufunktiot käyttöön
require "./tietokanta/yhteys.php";//tietokantayhteys käyttöön
require "./tietokanta/tkfunktiot.php";//tietokantafuntiot käyttöön

tulosta_alku();

tulosta_sisalto($sivu);

tulosta_loppu();
?>