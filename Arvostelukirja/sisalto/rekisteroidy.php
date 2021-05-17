<?php
$ok=false;
if(!empty($_POST['email']) && !empty($_POST['nimi']) && !empty($_POST['salasana1']) && !empty($_POST['salasana2'])) {
    $ok=TRUE;
    $nimi=$_POST['nimi'];
    $email= $_POST['email'];
    $salasana1= $_POST['salasana1'];
    $salasana2= $_POST['salasana2'];
    require "./tietokanta/yhteys.php";

    if($_POST['salasana1'] != $_POST['salasana2'] )$ok=FALSE;
    else {
        $nimi=putsaa($nimi);
        $liittynyt=date("Y,m,d");
        $salasana=$_POST['salasana1'];
        $salasana=muunna_salasana($salasana);
        $sql="INSERT INTO arvostelija (nimi,email,salasana,liittynyt) VALUES (?,?,?,?)";
        $kysely = $yhteys->prepare($sql);
        $kysely->execute(array($nimi,$email,$salasana,$liittynyt));
        if($kysely!=FALSE) echo "Rekisteröityminen onnistui, tervetuloa!";
    }
}
if(!$_POST || $ok==FALSE) {
    if(!empty($_POST))     {
        if(empty($_POST['email'])) echo "Sähköposti puuttuu! </br>";
        if(empty($_POST['nimi'])) echo "Etunimi puuttuu!</br>";
        if(empty($_POST['salasana1'])) echo "Toinen salasanoista puuttuu!</br>";
        if(empty($_POST['salasana2'])) echo "Toinen salasanoista puuttuu!</br>";
        if(!empty($_POST['salasana1']) && !empty($_POST['salasana2']))     {
            if($_POST['salasana1'] != ($_POST['salasana2']) )echo "Salasanat eivät vastaa toisiaan!</br>";
        }
    }

    ?>
    <br>
    <form method="post" action ="index.php?sivu=rekisteroidy">
    
    <p>
    <label for="etunimi">Nimesi: </label><br>
    <input type="text" name="nimi" value="<?php if(isset($_POST['nimi'])) echo $_POST['nimi'];?>">
    </p>

    <p>
    <label for="email">Sähköposti </label><br>
    <input type="email" name="email" value="<?php if(isset($_POST["email"])) echo $_POST['email'];?>">
    </p>
  
    <p>
    <label for="salasana1">Salasana</label><br>
    <input type="password" name="salasana1" value="<?php if(isset($_POST['salasana1'])) echo $_POST['salasana1'];?>">
    </p>

    <p>
    <label for="salasana2">Salasana uudelleen </label><br>
    <input type="password" name="salasana2" value="<?php if(isset($_POST['salasana2'])) echo $_POST['salasana2'];?>">
    </p>

    <p>
    <input class="button" type="submit" value="Rekisteröidy">
    </p>
    
    </form> 
<?php
}
?>