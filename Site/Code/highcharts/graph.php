
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<?php
require_once("dessiner_graph.php");

$v = explode("Sonde ",$_GET["Sondes"]);

$res = array();

global $connexion;


foreach($v as $i)
	$res[] = substr($i,0,-6);

unset($res[0]);


if( !empty($_GET["datedeb"]) && !empty($_GET["datefin"]))
    generer_Graphique($_GET["datedeb"],$_GET["datefin"], $res,"container" );
else
header('Location:../graphique.php');
?>

<input type="button" value="Recuperer les donnees" onclick="document.location.replace('Exportation_Fichier.php')" />