<?php  
	include('GestionBase.php');

	AjouterCorbeille($_POST['nom'],$_POST['posx'],$_POST['posz']);

	header("Location: ../administration.php");
?>