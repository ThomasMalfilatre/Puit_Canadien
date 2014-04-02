<?php require_once('../admin/ConnexionBD.php'); ?>

<script type='text/javascript' src='jquery.min.js'></script>
<script type="text/javascript" src="highcharts.js" ></script>
<script type="text/javascript" src="exporting.js" ></script>

<?php
Function generer_Graphique($dateDeb , $dateFin , $sondes, $conteneur){
	global $connexion;
	$tab = array(); // Initialisation du tableau des sondes

	$date_explosee = explode("/", $dateDeb);  // la fonction explode permet de séparer la chaine en tableau selon un délimiteur

	$jourDeb = $date_explosee[1];
	$moisDeb = $date_explosee[0];
	$anneeDeb = $date_explosee[2];

	$date_explosee = explode("/", $dateFin);

	$jourFin = $date_explosee[1];
	$moisFin = $date_explosee[0];
	$anneeFin = $date_explosee[2];

	$dateDeb = $anneeDeb."-".$moisDeb."-".$jourDeb;
	$dateFin = $anneeFin."-".$moisFin."-".$jourFin;

	foreach( $sondes as $val){
		 $tab[$val] = array(); // Pour chaque entrée on a une sonde a laquelle correspond un tableau contenant, la date de la temperature messurée


		$pstmt = $connexion->prepare("Select Sonde_id from Sonde where Nom = :nom");
		$pstmt -> bindParam(':nom', $val);
		$pstmt -> execute();
		$id = $pstmt -> fetch();
		


		 $stmt = $connexion->prepare("Select Date,Valeur from Temperature where Date >= :date_d  and Date <= :date_f and Sonde_id = :id_Sonde ");
		 // La requette selectionne les lignes correspondant au critères ( la sonde, la date de debut et fin )
		 $stmt -> bindParam(':date_d' , $dateDeb);
		 $stmt -> bindParam(':date_f' , $dateFin);
		 $stmt -> bindParam(':id_Sonde' , $id[0]);
		 $stmt -> execute();


		 foreach( $stmt as $requete ){ // pour chaque valeur (date,temperature) on les place dans le tableau tour a tour
		 	  $tab[$val][] = $requete[0];
		 	  $tab[$val][] = $requete[1];
		}
	}


?>

<script>
var dateDeb = new Date(<?php echo $anneeDeb.",".$moisDeb.",".$jourDeb; ?>); // on crée une variable date grace au précédent découpage
var dateFin = new Date(<?php echo $anneeFin.",".$moisFin.",".$jourFin; ?>);

$(function(){
        $('<?php echo "#".$conteneur; ?>').highcharts({
	    chart: {
	    zoomType: 'x' // permet de zoomer et dézoomer
	    },
            title: {
                text: 'Temperatures des sondes du ' + dateDeb.getDate() + ' / ' + (dateDeb.getMonth()) + ' / ' + dateDeb.getFullYear() + ' au ' + dateFin.getDate() + ' / ' + (dateFin.getMonth()) + ' / ' + dateFin.getFullYear() // affiche de la date de debut et de fin
            },
	    xAxis: {
                type: 'datetime', // type de donnée en abscisse
	    },
            yAxis: {
                title: {
                    text: 'Temperatures'
                }
            },
            plotOptions: {
                line: {
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    lineWidth: 1,
                    marker: {
                        enabled: false
                    },
                    shadow: false,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            series: [ // les séries de données
		<?php

		foreach( $tab as $s => $val2){ // pour chaque sondes
 			 $cpt = 0;// compteur pour savoir s'il s'agit d'une date, impair ou d'une température, pair
		 ?>
		{
                type: 'line',
                name: <?php echo "'" . $s ."',\n"; ?>
                data: [ 
		<?php
			 foreach( $val2 as $v ){
			 	  $cpt++;
				  if( $cpt%2 ==1 ){ // si on doit ecrire une date
				      if( $cpt > 1 )
				      	  echo ",\n";// si on va ecrire une date autre que la première
				  $separation = explode(" ", $v); // on separe la date de l'heure
				  $date  = explode("-", $separation[0]);// on décompose la date
				  $heure = explode(":", $separation[1]);// on décompose l'heure

			 	      echo "[Date.UTC(". $date[0] . ",". $date[1] . ",". $date[2] . ",". $heure[0] . ",". $heure[1] . "),";// on ecrit la date/heure avec la fonction Date.UTC
				  }
				  else // si on doit ecrire une temperature
				      echo $v . "]";
			}
		echo "],\n";// fin de la liste de donnée
		echo "},\n";// fin de la série
		}
		?>
	    ]
        });
    });

</script>

<?php
} // fin de la fonction
?>