<?php
	require_once '../admin/ConnexionBD.php';

	global $connexion;
	$stmt = $connexion -> prepare("SELECT * FROM Corbeille");
	$stmt -> execute();

	foreach ($stmt as $q) {
		$x = $q['posX'];
		$y = $q['posY'];
		$z = $q['posZ'];
		$nom = $q['Nom'];
		echo " <script> placer_corbeille('".$nom."',".$x.",".$y.",".$z."); </script>";
	}
?>