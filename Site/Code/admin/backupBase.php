<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Import/Export</title>
	</head>
	<body>
		<?php
			$host = "localhost";
			$user = "root";
			$pass = "29061994th";
			$db = "projet_tutore";

			if (isset($_POST['action'])){
				if ($_POST['action'] == 'import'){
					/* IMPORT */

					$dossier = 'upload/';
					$fichier = basename($_FILES['sql']['name']);
					$taille_maxi = 100000;	// En octets
					$taille = filesize($_FILES['sql']['tmp_name']);
					$extensions = array('.sql');
					$extension = strrchr($_FILES['sql']['name'], '.'); 

					//Début des vérifications de sécurité...
					if(!in_array($extension, $extensions)){ //Si l'extension n'est pas dans le tableau
						$erreur = 'Vous devez uploader un fichier de type .sql !';
					}
					if($taille > $taille_maxi){
						$erreur = 'Le fichier est trop gros...';
					}
					if(!isset($erreur)){ //S'il n'y a pas d'erreur, on upload
		    	 		//On formate le nom du fichier ici...
						$fichier = strtr($fichier, 
						'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
						'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
						$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
					}	
		     		if(move_uploaded_file($_FILES['sql']['tmp_name'], $dossier . $fichier)){ //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
		     	
		     			echo 'Upload effectué avec succès !<br /><br />';
		     			$command = "mysql -u $user -p$pass $db < upload/$fichier";
		     			$ligne = system($command);

		     			echo '<br />';
		     			echo 'Fichier importé !<br />';
		     			echo '<a href="../administration.php">Retour au panel d\'administration</a>';
		     		} else{
		     			echo 'Echec de l\'upload !<br/>';
		     			echo '<a href="../administration.php">Retour au panel d\'administration</a>';
		     		}
		 		} else {
		 			echo $erreur;
		     		echo '<br /><a href="../administration.php">Retour au panel d\'administration</a>';
		 		}
			} 
			elseif ($_POST['action'] == 'export'){
			/* EXPORT */

				$filename = $_POST['filename'];
				$backup = $filename.".sql";
				$command = "/usr/bin/mysqldump --host=$host --user=$user --password=$pass $db > dump/$backup";
		
				echo "La base est en cours d'export.......<br /><br />";
				system($command);

				echo "Lien vers le fichier .sql: <a href=\"dump/$backup\">$backup</a><br />";
		    	echo '<a href="../administration.php">Retour au panel d\'administration</a>';
			}
			else{
				header("Location: ../index.php");
			}
		?>
	</body>
</html>