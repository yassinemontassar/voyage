<?php
include '../../controlleur/voyageC.php';

$volC = new voyageC();
$volC->deleteVol($_GET["id_vol"]);
header('Location:liste_voyage.php');
?>
