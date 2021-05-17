<?php
/* Tiedosto hakee vanhat käyttäjän tiedot lomakkeelle ja submit-painikkeen painamisen jälkeen lähettää ne palvelimelle. Tietojen oikeellisuus tarkistetaan ja jos kaikki on kunnossa, päivitetään tietokantaan. * Jotta käyttäjän tietoja voi muuttaa, tarvitaan käyttäjäid, jonka saa istunnosta. 
Taulun kentät
* kid int(6) auto_increment (on siis autonumber tai laskuri-tyyppinen)
* sukunimi varchar(30)
* etunimi varchar(30)
* ktunnus varchar(30)
* salasana varchar(100)
*/
require "./tietokanta/yhteys.php";
$arvostelijaID=$_SESSION["arvostelijaID"];//hakee kirjautumisen kohdalla luodusta istuntomuuttujasta kirjautuneen käyttäjän kid:n


if(isset($_GET["mode"])) $mode=$_GET["mode"];
else $mode="muokkaa";

/*********************************************************************/
$istuntosalasana=$_SESSION["salasana"];//otetaan muuttujaan salasana, joka käyttäjällä on kirjautuessa
$tiedotok=false;
if(!empty($_POST["nimi"]) && !empty($_POST["email"]) && !empty($_POST["salasana"]) &&!empty($_POST["vanhasalasana"]) && muunna_salasana($_POST["vanhasalasana"])== $istuntosalasana) {
    //otetaan lähetetyt tiedot muuttujiin
    $etunimi=putsaa($_POST["nimi"]);
    $email=$_POST["email"];

    $tiedotok=true;

    //haetaan uudet salasanat ja tarkistetaan, että ne ovat samat. Jos ovat samat, otetaan uusi salasana muuttujaan $salasana
    if(!empty($_POST["salasana"]) && !empty($_POST["tokasalasana"]))     {

        if(putsaa($_POST["salasana"]) == putsaa($_POST["tokasalasana"])) {

            $salasana=muunna_salasana($_POST["salasana"]);
        }
        // jos eivät ole samat, mitään muutoksia ei tehdä
        else {
            $tiedotok=FALSE;
            echo "Uudet salasanat eivät vastaa toisiaan, muutoksia ei tehdä!<br>";
        }
    }
    //jos ei annettu, salasana napataan istunnosta eli vanha salasana jää voimaan
    else  {
    $salasana = $istuntosalasana;    
    }

    // salasanasuojataan lomakkeella annettu vanha salasana
    $vanhasalasana=muunna_salasana($_POST["vanhasalasana"]);

    //jos annettu vanha ei vastaa istunnossa olevaa salasanaa, muutosta ei tehdä
    if($istuntosalasana!=$vanhasalasana) {
        $tiedotok=FALSE;
        echo "Anna alkuperäinen salasana oikein!<br>";
    }

    if($tiedotok==true) {
        //rakennetaan sql-lause
        $sql="UPDATE arvostelija SET nimi=:nimi,email=:email,salasana=:salasana WHERE arvostelijaID=:arvostelijaID;";
        $kysely=$yhteys->prepare($sql);
        $kysely->execute(array(":nimi"=>$nimi,":email"=>$email,":salasana"=>$salasana,":arvostelijaID"=>$arvostelijaID));

        if($kysely) {
            echo "Tiedot muutettu";
            $tiedotok=true;
            $_SESSION["salasana"]=$salasana; //vaihdetaan istunnon salasanaa
        }
    }
} 

//jos tietoja puuttuu tai ei ole lähetetty lomaketta, haetaan olemassaolevat tiedot kannasta
if($tiedotok==false){

    $sql="SELECT * FROM arvostelija WHERE arvostelijaID='$arvostelijaID'";//huom, tieto istunnosta, ei vaarallinen
    $kysely=$yhteys->query($sql);
    if(!$kysely) echo "Käyttäjää ei löydy.";
    else     {//arvot kannasta muuttujiin 
        $rivi = $kysely->fetchAll(PDO::FETCH_ASSOC); 
        $nimi=$rivi[0]["nimi"];
        $salasana=$rivi[0]["salasana"];
        $email=$rivi[0]["email"];
    }
?>
<br><br>

    <form action="admin.php?sivu=muokkaa_omia_tietoja&mode=muokkaa&arvostelijaID=<?php echo $arvostelijaID;?>" method="post">
    
    <p>
    <label for="nimi">* Nimi </label><br>
    <input type="text" name="nimi" value="<?php if(isset($nimi)) echo $nimi;?>">
    </p>
    
    <p>
    <label for="sposti">* Sähköposti </label><br>
    <input type="email" name="sposti" value="<?php if(isset($email)) echo $email;?>">
    </p>

    <p>    Salasanan muutos</p>
    
    <p>
    <label for="salasana">Uusi salasana </label><br>
    <input type="password" name="salasana">
    </p>
    
    <p>
    <label for="tokasalasana">Uusi salasana uudelleen </label><br>
    <input type="password" name="tokasalasana"?>
    </p>
    
    <p>
    <label for="vanhasalasana">* Vanha salasana (pakollinen kaikissa muutoksissa)</label><br>
    <input type="password" name="vanhasalasana">
    </p>
    
    <p>
    <input class="button" type="submit" value="Muuta tiedot">
    </p>
    
    </form>

<?php
}
?>