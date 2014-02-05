<?php 
	include('GestionBase.php');

	suppressionPuits($_POST['nom']);

	header("Location: ../administration.php");

 ?>