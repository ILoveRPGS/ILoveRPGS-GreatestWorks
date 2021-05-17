<?php 
if(isset($_GET["puuttuu"])) echo "<p>Täytä molemmat kentät!</p>";
if(isset($_GET["vaarin"])) echo "<p>Käyttäjätunnus ja salasana eivät vastaa toisiaan</p>";

?>

<form action="./tarkista_kirjautuminen.php" method="post">
<h2>Kirjaudu</h2>

<p>
<label for="ktunnus">Sähköpostisi</label><br>
<input type="text" name="email"><br>
</p>

<p>
<label for="salasana">Salasanasi</label><br>
<input type="password" name="salasana"><br>
</p>

<p>
<input class="button" type="submit" value="Kirjaudu">
</p>
</form>
<?php


