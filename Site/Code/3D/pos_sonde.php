<?php
	require_once 'admin/ConnexionBD.php';

	global $connexion;
	$stmt = $connexion -> prepare("SELECT * FROM Sonde");
	$stmt -> execute();

	foreach ($stmt as $q) {
		$x = $q['posX'];
		$y = $q['posY'];
		$z = $q['posZ'];
		$nom = $q['Nom'];
		if($x != 0){
			if($nom[0] == 'A'){
				if($nom[1] == 'i')
					echo " <script> placer_sonde('".$nom."',".$x.",".$y.",".$z.",255,255,255); </script>";
				else
					echo " <script> placer_sonde('".$nom."',".$x.",".$y.",".$z.",255,0,0); </script>";
			}	
			elseif($nom[0] == 'B')
				echo " <script> placer_sonde('".$nom."',".$x.",".$y.",".$z.",0,255,0); </script>";
			elseif($nom[0] == 'C')	
				echo " <script> placer_sonde('".$nom."',".$x.",".$y.",".$z.",0,0,255); </script>";
			elseif($nom[0] == 'D')	
				echo " <script> placer_sonde('".$nom."',".$x.",".$y.",".$z.",255,0,255); </script>";
			elseif($nom[0] == 'E')
				echo " <script> placer_sonde('".$nom."',".$x.",".$y.",".$z.",205,85,0); </script>";
			elseif($nom[0] == 'R')
				echo " <script> placer_sonde('".$nom."',".$x.",".$y.",".$z.",125,125,125); </script>";
			elseif($nom[0] == 'T')
				echo " <script> placer_sonde('".$nom."',".$x.",".$y.",".$z.",255,255,255); </script>";
			elseif($nom[0] == 'V')
				echo " <script> placer_sonde('".$nom."',".$x.",".$y.",".$z.",255,255,0); </script>";
			else
				echo " <script> placer_sonde('".$nom."',".$x.",".$y.",".$z.",0,0,0); </script>";

		}
	}	
?>