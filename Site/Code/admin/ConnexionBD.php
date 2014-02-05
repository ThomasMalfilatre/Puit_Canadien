<?php

	require_once 'config.php';

	$dsn = "mysql:dbname=".BASE.";host=".HOST;
	try{
		$connexion = new PDO($dsn,USER,PASS);
	}
	catch(PDOException $e){
		printf("Echec de la connexion : %s\n", $e->getMessage());
		exit();
	}

  // $result = $bdd->prepare("SELECT * from Sonde");
  // $temperatures = $bdd->prepare("SELECT * FROM Temperature");
  // $result->execute();
  // $temperatures->execute();

  // $nbSondes = $result->rowCount();
  // $nbTemp = $temperatures->rowCount();
?>