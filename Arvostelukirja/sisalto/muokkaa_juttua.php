<?php
require "./tietokanta/yhteys.php";
if(isset($_GET["arvosteluID"])) $arvosteluID=$_GET["arvosteluID"];
else $arvosteluID="";
if(isset($_GET["mode"])) $mode=$_GET["mode"];
else $mode="muokkaa";
if($mode=="poista")
{
    $sql="DELETE FROM arvostelu WHERE arvosteluID=?"; 
    $kysely = $yhteys->prepare($sql); 
    $kysely->execute(array($arvosteluID));
    header("Location:admin.php");
}
if($mode=="muokkaa") {
    if(!empty($_POST["otsikko"]) && !empty($_POST["teksti"])){
        $kirjoitettu = date('Y-m-j');
        $otsikko = $_POST['otsikko'];
        $otsikko = putsaa($otsikko);
        $teksti = $_POST['teksti'];
        $teksti = putsaa($teksti);
        $kokonaisarvio = $_POST['kokonaisarvio'];
        $aiheID = $_POST['aihe'];
        

        $arvostelijaID=$_SESSION["arvostelijaID"];

        $sql = "UPDATE arvostelu set otsikko=:otsikko,teksti=:teksti,kirjoitettu=:kirjoitettu,kokonaisarvio=:kokonaisarvio,aiheID=:aiheID WHERE arvosteluID=:arvosteluID";

        $kysely = $yhteys->prepare($sql);
        $kysely->execute(array(":otsikko"=>$otsikko,":teksti"=>$teksti,":kirjoitettu"=>$kirjoitettu,":kokonaisarvio"=>$kokonaisarvio,":aiheID"=>$aiheID,":arvosteluID"=>$arvosteluID));
        if($kysely){
            echo "Tiedot muutettu!<br>";
            echo "<a href=\"admin.php\">Palaa juttuluetteloon.</a><br>";   
            }
        }
    
     
        else {

    /********************************************************************
    Jos tietoja puuttuu tai tullaan ensimmäistä kertaa sovellukseen,
    tulostetaan lomake (valmiit tiedot lomakkeeseen). Jos tietoja puuttuu
    tulostetaan niistä ilmoitus
    ********************************************************************/

        echo "Täytä lomake kokonaan, pakolliset kentät on merkitty tähdellä.";
        if(!empty($_POST)) {
            if (empty($_POST['otsikko'])) echo "Kirjoita otsikko";    
            if (empty($_POST['teksti'])) echo "Kirjoita itse juttu";
        }
        else {
            $sql="SELECT * FROM arvostelu WHERE arvosteluID=?";
            $kysely = $yhteys->prepare($sql);
            $kysely->execute(array($arvosteluID));

            $rivi = $kysely->fetchAll(PDO::FETCH_ASSOC); 
            if(!$rivi)echo"Juttua ei löydy ";
            else{
              $otsikko=$rivi[0]["otsikko"];
                $teksti=$rivi[0]["teksti"];
                $arvostelijaID=$rivi[0]["arvostelijaID"];
                }
            }
        
        ?>
        <form action="./admin.php?sivu=muokkaa_juttua&mode=muokkaa&arvosteluID=<?php echo $arvosteluID;?>" method="post">
        
        <p>
        <label for="otsikko">* Otsikko</label><br>
        <input type="text" name="otsikko" value="<?php if(isset($otsikko)) echo $otsikko;?>">
        </p>

        <p>
        <label for="otsikko">* Teksti</label><br>
        <textarea name="teksti" cols="45" rows="5"><?php if(isset($teksti)) echo $teksti?></textarea>
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
        <input class="button" type="submit" value="Muokkaa juttua" name="painike">
        </p>
        
        </form>

        <?php
        
    }
}
?>