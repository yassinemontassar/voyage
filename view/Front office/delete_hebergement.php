<?php
include '../../controlleur/hebergementC.php';

$hebergementC = new HebergementC();
$hebergementC->deleteHebergement($_GET["id_hebergement"]);
header('Location:liste_hebergement.php');
?>
