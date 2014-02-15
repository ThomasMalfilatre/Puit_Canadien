<?php 
	include('GestionBase.php');

	suppressionCorbeille($_POST['id']);

	header("Location: ../administration.php"); 
?>