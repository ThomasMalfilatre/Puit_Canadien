<?php 
	include('GestionBase.php');

	AjouterSonde($_POST['nom'], $_POST['niveau']);
	echo "Sonde ajoute";

	AjouterDependance($_POST['nom'], $_POST['relier']);

	header("Location: ../administration.php");
?>