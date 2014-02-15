<?php
	include('GestionBase.php');

	suppressionSonde($_POST['id']);

	header("Location: ../administration.php");

?>