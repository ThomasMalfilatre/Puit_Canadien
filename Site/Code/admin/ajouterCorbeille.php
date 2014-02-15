<?php  
	include('GestionBase.php');

	AjouterCorbeille($_POST['nom']);

	header("Location: ../administration.php");
?>