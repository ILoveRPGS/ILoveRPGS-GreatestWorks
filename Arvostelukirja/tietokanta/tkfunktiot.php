<?php

/* Funktio palauttaa käyttäjän id:n*/
function hae_id_kannasta($email,$salasana) 
{
    require "./tietokanta/yhteys.php";
    $id=NULL;
    $lause = $yhteys->prepare("SELECT * FROM arvostelija WHERE email=:email AND salasana =:salasana");
    $lause->bindParam(':email', $email);
    $lause->bindParam(':salasana', $salasana);
    
    $lause->execute();

    $rivi = $lause->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($rivi)) $id = $rivi[0]["arvostelijaID"];
    return $id;
}

function kayttajan_nimi($arvostelijaID,$yhteys) 
{
    $sql="SELECT nimi FROM arvostelija WHERE arvostelijaID=?";

    $teksti="";

    $kysely=$yhteys->prepare($sql);
    $kysely->execute(array($arvostelijaID));

    $rivi=$kysely->fetchAll(PDO::FETCH_ASSOC);
    if(empty($rivi)) $teksti= "Käyttäjää ei löydy.";
    else {
        $nimi=$rivi[0]["nimi"];
        $teksti.= $nimi." ";
    }
    return $teksti;
}
?>