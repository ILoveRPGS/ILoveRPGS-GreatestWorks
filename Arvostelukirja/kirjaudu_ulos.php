<?php
session_start(); //aloittaa session, huom, pelkkää html:ää ei saa tulostaa ennen tämän lähettämistä
if(!isset($_SESSION['kid'])) header("Location: ./index.php?sivu=kirjaudu");
else {
    session_unset(); //poistaa kaikki muuttujat
    session_destroy();
    setcookie(session_name(),'',0,'/'); //poistaa evästeen selaimesta
    session_regenerate_id(true);
    header("Location: ./index.php?sivu=kirjaudu"); // forward eli uudelleenohjaus
    die();
}
?>