<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php
			include('block/head/head.php');
			include('admin/GestionBase.php');
		?>
	
		<link rel='stylesheet' type='text/css' href='css/administration.css' />
		<link rel="stylesheet" href="css/jquery-ui.css" />
	
		<script type="text/javascript" src="scripts/jquery/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="scripts/jquery/jquery-ui.js"></script>
		<script type="text/javascript" src="scripts/jquery/jquery-ui-i18n.min.js"></script>
		<script type="text/javascript" src="admin/menu.js"></script>

		<script type="text/javascript">
			$(document).ready(function () { 
				$(function() {
					$( "#selectable" ).selectable();
					$( "#selectable2" ).selectable();
					$( "#selectable3" ).selectable();
				});
				$(function() {
					$("#tabs").tabs();
				});
				$('#supprSonde').click(function () {
					$('#selectable .ui-widget-content.ui-selected').each(function(index) {
						var tmp = $(this).attr('data-userid');
						$.post('admin/supprSonde.php', { id : tmp })
						.done(function (data) { location.reload(); })
						.fail(function (data) {});
					});
				});
				$('#supprCorbeille').click(function () {
					$('#selectable2 .ui-widget-content.ui-selected').each(function(index) {
						var tmp = $(this).attr('data-userid');
						$.post('admin/supprCorbeille.php', { id : tmp })
						.done(function (data) { location.reload(); })
						.fail(function (data) {});
					});
				});
				$('#supprPuits').click(function () {
					$('#selectable3 .ui-widget-content.ui-selected').each(function(index){
						var tmp = $(this).text();
						$.post('admin/supprPuits.php', { nom : tmp })
						.done(function (data) { location.reload(); })
						.fail(function (data) {  });
					});
				});	

				<?php
					$res = nomCorbeille();
					$res2 = nomPuits();

					while( $data = $res->fetch(PDO::FETCH_ASSOC) ){
						echo "$('#sondeCorbeille').append('<option>" . $data['Nom'] . "');";
					}
		
					while( $data = $res2->fetch(PDO::FETCH_ASSOC)){
						echo "$('#sondeCorbeille').append('<option>" . $data['Nom_puits']. "');";
					}
				?>
			});
		</script>

		<style>
			#feedback { font-size: 0.8em; }
			#selectable .ui-selecting { background: #FECA40; }
			#selectable .ui-selected { background: #F39814; color: white; }
			#selectable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
			#selectable li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }

			#selectable2 .ui-selecting { background: #FECA40; }
			#selectable2 .ui-selected { background: #F39814; color: white; }
			#selectable2 { list-style-type: none; margin: 0; padding: 0; width: 60%; }
			#selectable2 li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }

			#selectable3 .ui-selecting { background: #FECA40; }
			#selectable3 .ui-selected { background: #F39814; color: white; }
			#selectable3 { list-style-type: none; margin: 0; padding: 0; width: 60%; }
			#selectable3 li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
		</style>
	</head>

	<body>
		<?php include("admin/pass.php"); ?> <!-- Verifie le mot de passe de l'admin -->
		<div id="centrer">
			<?php include('block/body/header.php'); ?>
			<div id='contenu'>
				<div id="tabs">
					<ul>
						<li><a href="#tabs-1">Ajouter une sonde</a></li>
						<li><a href="#tabs-2">Ajouter une corbeille</a></li>
						<li><a href="#tabs-3">Ajouter un puits</a></li>
						<li><a href="#tabs-4">Supprimer une sonde</a></li>
						<li><a href="#tabs-5">Supprimer une corbeille</a></li>
						<li><a href="#tabs-6">Supprimer un puits</a></li>
						<li><a href="#tabs-7">Importation ou exportation</a></li>
						<li><a href="#tabs-8">Arduino</a></li>
					</ul>

					<div id="tabs-1">
						<form action="admin/ajouterSonde.php" method="post">     
							<fieldset>
								<legend>Ajouter une sonde</legend>
								<table>
									<tr>
										<td>
											<label for="relier"> Appartient à : </label>
										</td>
										<td>
											<select name="relier" id="sondeCorbeille"></select>
										</td>
									</tr>
									<tr>
										<td>
											<label for="nom">Nom de la sonde : </label>
										</td>
										<td>
											<input type="text" name="nom" id="nom" size="30" maxlength="10" />
										</td>
									</tr>
									<tr>
										<td>
											<label for="niveau">Niveau : </label>
										</td>
										<td>
											<select name="niveau">
												<option value="0">0</option>
												<option value="1">1</option>
												<option value="2.5">2.5</option>
												<option value="4">4</option>
										</td>	
									</tr>
									<tr>
										<td colspan="2">
											<input type="submit" value="Ajouter" />
										</td>
									</tr>
								</table>
							</fieldset>
						</form>
					</div>
					
					<div id="tabs-2">
						<form action="admin/ajouterCorbeille.php" method="post">     
							<fieldset>
								<legend>Ajouter une Corbeille</legend>
								<table>
									<tr>
										<td>
											<label for="nom">Nom de la corbeille : </label>
										</td>
										<td>
											<input type="text" name="nom" id="nom" size="30" maxlength="10" />
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<input type="submit" value="Ajouter" />
										</td>
									</tr>
								</table>
							</fieldset>
						</form>
					</div>

					<div id="tabs-3">
						<form action="admin/ajouterPuits.php" method="post">     
							<fieldset>
								<legend>Ajouter un Puits</legend>
								<table>
									<tr>
										<td>
											<label for="nom">Nom du Puit : </label>
										</td>
										<td>
											<input type="text" name="nom" id="nom" size="30" maxlength="10" />
										</td>
									</tr>
									<tr>
										<td colspan="2"><input type="submit" value="Ajouter" /></td>
									</tr>
								</table>
							</fieldset>
						</form>	
					</div>

					<div id="tabs-4">
						<fieldset>
						<legend>Supprimer une sonde</legend>
							<table>
								<tr>
									<div class="tabs-listeSondes">
										<ul id="selectable">
											<?php
												$res = nomSonde();
												while( $data = $res->fetch(PDO::FETCH_ASSOC) ){
													echo '<li class="ui-widget-content" data-userid="' . $data['Sonde_id'] . '">' . $data['Nom'] . '</li>';
												}
											?>
										</ul>
									</div>
								</tr>
								<tr>
									<td colspan="2">
										<button type="button" id="supprSonde">Supprimer</button>
									</td>
								</tr>
							</table>
						</fieldset>
					</div>

					<div id="tabs-5">
						<fieldset>
							<legend>Supprimer une corbeille</legend>
							<table>
								<tr>
									<div class="tabs-listeSondes">
										<ul id="selectable2">
											<?php
												$res = nomCorbeille();
												while( $data = $res->fetch(PDO::FETCH_ASSOC) ){
													echo '<li class="ui-widget-content" data-userid="' . $data['Corbeille_id'] . '">' . $data['Nom'] . '</li>';
												}
											?>
										</ul>
									</div>
								</tr>
								<tr>
									<td colspan="2">
										<button type="button" id="supprCorbeille">Supprimer</button>
									</td>
								</tr>
							</table>
						</fieldset>
					</div>

					<div id="tabs-6">
						<fieldset>
							<legend>Supprimer un puits</legend>
							<table>
								<tr>
									<div class="tabs-listeSondes">
										<ul id="selectable3">
											<?php
												$res = nomPuits();
												while( $data = $res->fetch(PDO::FETCH_ASSOC) ){
													echo '<li class="ui-widget-content" data-userid=>'. $data['Nom_puits'] . '</li>';
												}
											?>
										</ul>
									</div>
								</tr>
								<tr>
									<td colspan="2">
										<button id="supprPuits">Supprimer</button>
									</td>
								</tr>
							</table>
						</fieldset>
					</div>

					<div id="tabs-7">
						<fieldset>
							<legend>Import/Export</legend>
							<table>
								<tr>
									<form name="import" enctype="multipart/form-data" action="admin/backupBase.php" method="post">
										<fieldset>
											<legend>Import de fichier .sql</legend>
											Fichier .sql: <input type="file" name="sql" required /><br />
											<input type="hidden" name="action" value="import" />
											<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
											<input type="submit" value="Valider" />
										</fieldset>
									</form>
									<br />
									<form name="export" action="admin/backupBase.php" method="post">
										<fieldset>
											<legend>Export de la base</legend>
											Nom du fichier: <input type="text" name="filename" required /><br />
											<input type="hidden" name="action" value="export" />
											<input type="submit" value="Valider" />
										</fieldset>
									</form>
								</tr>
							</table>
						</fieldset>
					</div>

					<div id="tabs-8">
						<fieldset>
							<legend>Arduino</legend>
							<table>
								<tr>
									<form name="chgFreq" action="admin/arduino.php" method="post">
										<fieldset>
											<legend>Changement de la fréquence des saisies</legend>
											Fréquence (en ms): <input type="number" name="freq" required /><br />
											<input type="submit" value="Valider" />
										</fieldset>
									</form>
								</tr>
							</table>
						</fieldset>
					</div>
				</div> <!--tabs-->
			</div> <!--contenu-->
		</div> <!--centrer-->
		<?php include('block/body/footer.php'); ?>
	</body>
</html>
