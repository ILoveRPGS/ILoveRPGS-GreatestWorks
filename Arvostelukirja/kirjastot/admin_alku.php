
<!DOCTYPE html>
<html>
<head>
<title>Vieraskirja</title>
<meta charset=utf-8>
<meta name="keywords" content="sivukoe, CSS3, HTML5">
<meta name="author" content="Leena Järvenkylä-Niemi">
<meta name="description" content="Vieraskirja">
<script src="datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" href="./tyyli/sivu.css" />
<script src="datetimepicker.js"></script>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&family=Yusei+Magic&display=swap" rel="stylesheet">
</head>
<body>
<header>

<div id="kotisivulinkki">
<a class="kotilinkki" href="admin.php"><h2 class="joo">Arviokirja-ylläpito</h2></a>
</div>

<nav>
    <?php
    if(isset($_SESSION["arvostelijaID"])) $arvostelijaID=$_SESSION["arvostelijaID"];
    if($arvostelijaID==9){
        echo '<a class="navilinkki" href="admin.php?sivu=kayttajien_hallinta">Hallinnoi käyttäjiä</a>';
    }
    ?>
<a class="navilinkki" href="admin.php?sivu=lisaa_juttu">Lisää arvostelu</a>
<a class="navilinkki" href="admin.php?sivu=muokkaa_omia_tietoja">Muokkaa omia tietoja</a>
<a class="navilinkki" href="admin.php?sivu=lisaa_aihe">Lisää aihe</a>
<a class="navilinkki" href="kirjaudu_ulos.php">Kirjaudu ulos</a>
</nav>

</header><!--ylaosa loppuu-->

<div id="keskiosa">
<div id="teksti">