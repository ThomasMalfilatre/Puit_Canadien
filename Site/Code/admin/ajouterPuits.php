<?php  
	include('GestionBase.php');

	AjouterPuits($_POST['nom']);

	header("Location: ../administration.php");
?>