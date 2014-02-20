<form>
	<br />
	<br />

	Liste des sondes sélectionnées : 

	<br />
	<br />
	
	<div id="baseSondes"></div> <!-- div qui contiendra la liste des sondes selectionnées -->
	
	<br />
	<br />
	
	<script src="scripts/jquery/jquery-1.9.1.js"></script>
	<script src="scripts/jquery/jquery-ui.js"></script>
	<label>Date de début</label>
	<script>
		$(function() {
			$( "#datepicker" ).datepicker();
		});
	</script>
	<input type="text" name="datedeb" id="datepicker"/>

	<br />
	<br />

	<label>Date de fin</label>
	<br />
	<script>
		$(function() {
			$( "#datepicker2" ).datepicker();
		});
	</script>
	<input type="text" name="datefin" id="datepicker2"/>
</form>

