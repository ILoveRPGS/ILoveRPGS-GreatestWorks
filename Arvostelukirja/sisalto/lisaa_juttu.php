<?php

/******************
Taulun rakenne
jid int(6) auto_increment (on siis autonumber tai laskuri-tyyppinen), pääavain
otsikko varchar(100)
kpl text
poistamispvm date NOT NULL
lisayspvm date
kid int(6)
**********************/
require "./tietokanta/yhteys.php";
if (!empty($_POST["otsikko"]) && !empty($_POST["teksti"])) {
    $lisayspvm = date('Y-m-j');
    $otsikko = $_POST['otsikko'];
    $otsikko = putsaa($otsikko);
    $teksti = $_POST['teksti'];
    $teksti=putsaa($teksti);
    $aiheID=$_POST['aihe'];
    $arvostelijaID=$_SESSION["arvostelijaID"];
    $kokonaisarvio=$_POST['kokonaisarvio'];

    $sql = "INSERT INTO arvostelu (otsikko,teksti,kirjoitettu,arvostelijaID,aiheID,kokonaisarvio) VALUES (?,?,?,?,?,?)";

    $kysely=$yhteys->prepare($sql);
    $kysely->execute(array($otsikko,$teksti,$lisayspvm,$arvostelijaID,$aiheID,$kokonaisarvio)); if($kysely!=FALSE) echo "Tiedot lisätty";
    else echo "Lisäys ei onnistunut, yritä myöhemmin uudelleen";
}
else {

/********************************************************************
Jos tietoja puuttuu tai tullaan ensimmäistä kertaa sovellukseen,
tulostetaan lomake (valmiit tiedot lomakkeeseen). Jos tietoja puuttuu
tulostetaan niistä ilmoitus
********************************************************************/

    echo "Täytä lomake kokonaan, pakolliset kentät on merkitty tähdellä.";
    if(isset($_POST["painike"])) {
        if (!isset($_POST['otsikko'])) echo "Kirjoita otsikko";    
        if (!isset($_POST['teksti'])) echo "Kirjoita myös juttu";
    }
?>

    <form action="./admin.php?sivu=lisaa_juttu" method="post">
    
    <p>
    <label for="otsikko">* Otsikko</label><br>
    <input type="text" name="otsikko" value="<?php if(isset($_POST["otsikko"])) echo $_POST["otsikko"]?>">
    </p>

    <p>
    <label for="teksti">* Teksti</label><br>
    <textarea name="teksti" cols="45" rows="5"><?php if(isset($_POST["teksti"])) echo $_POST["teksti"]?></textarea>
    </p>
    <label for="kokonaisarvio">Pelin arvosana:</label>
    <select name="kokonaisarvio">
    <option value='1'>1</option>
    <option value='2'>2</option>
    <option value='3'>3</option>
    <option value='4'>4</option>
    <option value='5'>5</option>
    </select><br>
    <label for="aihe">Valittavat pelit:</label>
    <select name="aihe">
    <!-- haetaan tietokannasta sisältö: -->
    <?php
    $sql="SELECT * FROM aiheet ORDER BY aihenimi";
    $kysely=$yhteys->prepare($sql);
    $kysely->execute();
    $rows = $kysely->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
    $aiheID = $row["aiheID"];
    $nimi = $row["aihenimi"];
    echo "<option value='$aiheID'>$nimi</option>";
    }
    ?>
    </select>

    <p>
    <input class="button" type="submit" value="Lisää juttu" name="painike">
    </p>

    
    </form>

<?php
}
?>