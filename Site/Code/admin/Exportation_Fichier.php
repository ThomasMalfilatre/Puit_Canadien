<?php

	require_once("config.php");


	/* =====================================================================================
	 Cette fonction prend en parametre une date de debut une date de fin et une sonde.
	 Elle interoge la base de donnée afin de gerer un fichier ods ( format libre office tableur )
	 qui contient les données de temperature demandées.
	 Les variables renseignant les dates doivent être au format suivant : 
	 '2013-02-25' ou si on veut plus de précision : '2013-02-25 19:20:00'
	 les id de sondes sont de simples nombre : '1' , '15' ...
	 exemple d'appel : Exportation_Fichier ( '2013-02-14' , '2013-02-15 19:20:00' , '1' )

	 /!\ le dossier ou sera placer le fichier doit avoir les droits d'ecriture de même que ce fichier
	 sinon cela posera probleme, actuellement c'est le dossier WWW.
	===================================================================================== */

	Function Exportation_Fichier( $date_deb , $date_fin , $id_sonde ){

		 global $bdd;

		 $stmt = $bdd->prepare("Select * from Temperature where Date >= :date_d and 
		       	 			       	    		      Date <= :date_f and
									      Sonde_id = :id_s");// requete pour recuperer les donnes demandees
	         $stmt->bindParam(':date_d' , $date_deb);	
	         $stmt->bindParam(':date_f' , $date_fin);		  
	         $stmt->bindParam(':id_s' , $id_sonde);			  
		 $stmt->execute();

			  
		if( !empty($stmt) ){// s'il y a un resultat
		    $nom = $_SERVER['DOCUMENT_ROOT'] . '/Sonde' . $id_sonde . '_' . $date_deb . '_' . $date_fin . '.ods'; 
		    $fichier = fopen( $nom , 'w' );// on cree un fichier ods
		    fwrite($fichier ,  "Nom_sonde" . chr(59));
		    fwrite($fichier ,  "Date" . chr(59));
	 	    fwrite($fichier ,  "Heure" . chr(59));
		    fwrite($fichier ,  "Temperature\n\n");

		    foreach( $stmt as $valeur ) // on insere les valeur dans le fichier
		    {
		    	     fwrite($fichier ,  $valeur[0] . chr(59)); //ID de la sonde
			     fwrite($fichier ,  $valeur[1] . chr(59));//date et heure de la prise de temperature
			     fwrite($fichier ,  $valeur[2]."\n\n");//valeur de la temperature
		    }

	 	    fclose($fichier);// fermeture du fichier
		}
	}
?>