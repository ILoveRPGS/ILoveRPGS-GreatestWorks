<?php
require "yhteys.php";

if (isset($_GET["id"])) {
$sql = "DELETE FROM arvostelija WHERE arvostelijaID=?";
$data = array($_GET["id"]);
$kysely = $yhteys->prepare($sql);
$kysely->execute($data);
header('Location: ../admin.php?sivu=kayttajien_hallinta');
exit;
}
?>