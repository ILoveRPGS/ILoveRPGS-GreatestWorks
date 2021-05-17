<?php
require "./tietokanta/tkfunktiot.php";
require "./kirjastot/funktiot.php";
if(!empty($_POST["email"]) && !empty($_POST["salasana"])) {
    $email = $_POST["email"];
    $salasana = $_POST["salasana"];
    $salasana=muunna_salasana($salasana);
    require "./tietokanta/yhteys.php";
    $arvostelijaID = hae_id_kannasta($email,$salasana);        
    if(!empty($arvostelijaID)) {
        session_start();
        $_SESSION["arvostelijaID"] = $arvostelijaID;
        $_SESSION["istuntoid"] = session_id();
        $_SESSION["salasana"]=$salasana;
        header("Pragma: No-Cache");
        header("Location: admin.php");
        die();
         }
    else{
        header("Location: index.php?sivu=kirjaudu&vaarin=true");
    } 
}
else header("Location: index.php?sivu=kirjaudu&puuttuu=true");