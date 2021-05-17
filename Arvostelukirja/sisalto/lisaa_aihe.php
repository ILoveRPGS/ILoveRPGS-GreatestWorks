<?php
require "./tietokanta/yhteys.php";
if (!empty($_POST["aihenimi"]) && !empty($_POST["kuvaus"])) {
    $nimi = $_POST['aihenimi'];
    $nimi = putsaa($nimi);
    $kuvaus = $_POST['kuvaus'];
    $kuvaus=putsaa($kuvaus);
    $sql = "INSERT INTO aiheet (aihenimi,kuvaus) VALUES (?,?)";

    $kysely=$yhteys->prepare($sql);
    $kysely->execute(array($nimi,$kuvaus)); 
    if($kysely!=FALSE) echo "Tiedot lisätty";
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
        if (!isset($_POST['aihenimi'])) echo "Kirjoita otsikko";    
        if (!isset($_POST['kuvaus'])) echo "Kirjoita myös juttu";
    }

?>




<form action="./admin.php?sivu=lisaa_aihe" method="post">
    </select><br>
    <label for="aihe">Jos tallentaminen onnistui se näkyy täällä:</label><br>
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
    <br><br>
    <label for="aihenimi">Pelin nimi:</label>
    <input type="text" name="aihenimi"><br><br>
    <h2>Kuvaus:</h2>
    <textarea rows="10" cols="30" name="kuvaus"></textarea>


    <p>
    <input class="button" type="submit" value="Lisää juttu" name="painike">
    </p>
</form>
<?php
}
?>