<script type="text/javascript">
	// Chart et options
	var chart, options;

	// Dates par défaut
	var begin = new Date(new Date().setDate(new Date().getDate()-30));
	var end = new Date();

	$(document).ready(function(){

		      // Mise en place du datepicker
		      $(function(){
			    $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );

    			    $('#debut').datepicker();
    			    $('#fin').datepicker();

    			    $('#debut').datepicker("setDate", begin);
    			    $('#fin').datepicker("setDate", end);
				});

		      $('#')

		      // Récupération des sondes
			  <?php
    		      $sondeAct = "";
      		      $premiereVal = true;
      		      $cpt = 0;
      		      while ($data = $result->fetch(PDO::FETCH_ASSOC)){
	  		  		if ($premiereVal){
			      $sondeAct = substr($data['Nom'], 0, 2);
			      $premiereVal = false;
	  		  }
	  		  ++$cpt;

	  		  if ($sondeAct != substr($data['Nom'], 0, 2))
	  		  {
	     		      $sondeAct = substr($data['Nom'], 0, 2);
	      		      echo "$('#baseSondes').append('<br/>');" ;
	      		      $cpt = 0;
	  		  }

	  		  else if ($cpt == 4)
	  		  {
	      		      $cpt = 0;
	      		      echo "$('#baseSondes').append('<br/>');" ;
	  		  }

	  		  echo "$('#baseSondes').append('<input id=\"" .$data['Sonde_id'] . "\" type=\"checkbox\" /><label>" . $data['Nom'] . "</label>    ');";
      		      }

		      $result->closeCursor();
		      $result->execute();
		      echo "$('#baseSondes').before('<br/>');";
			  ?>

		      var all_checked = true;

		      // Options du graphique
		      var options = {
			  chart: {
	    		      renderTo: 'graph',
			      type: 'spline',
			      marginBottom: 50
	  		  },
	  		  title: {
	      		      text: 'Températures des sondes',
	      		      x: -20
	  		  },
	  		  subtitle: {
	    		      text: '',
	      		      x: -20
	  		  },
	  		  xAxis: {
	      		      type: 'datetime',
	      		      tickWidth: 0,
	      		      gridLineWidth: 1,
	      		      min: begin,
	      		      max: end,
	      		      title: {
		  		  text: 'Date et heure',
		  		  margin: 10
	      		      },
	      		      labels: {
		  		  align: 'center',
		  		  x: -3,
		  		  y: 20
	      		      }
	  		  },
	  		  yAxis: {
	    		      title: {
		  		  text: 'Température (°C)'
	      		      },
	      		      plotLines: [{
		  		  value: 0,
		  		  width: 1,
		  		  color: '#808080'
	      		      }]
	  		  },
	  		  tooltip: {
	    		      formatter: function() {
				  return Highcharts.dateFormat('%d %b %Y %H:%M:%S', this.x) +' - <b>'+ this.y + '</b>';
	    		      }
	  		  },
	  		  legend: {
	    		      layout: 'vertical',
	      		      align: 'right',
	      		      verticalAlign: 'top',
	      		      x: -10,
	      		      y: 100,
	      		      borderWidth: 0
	  		  },
	  		  series: [

	    		      // Récupération des températures
				  <?php
				  /*
	      		      $cpt = 0;
	      		      while ($data = $result->fetch(PDO::FETCH_ASSOC))
	      		      {
		  		  $tempStr = "";
		  		  $bool = false;

		  		  while ($tmp = $temperatures->fetch(PDO::FETCH_ASSOC))
		  		  {
		      		      if ($tmp['Sonde_id'] == $data['Sonde_id'])
		      		      {
			  		  $datetime = new DateTime($tmp['Date']);

			  		  if ($bool) $tempStr = $tempStr . ', [' .  $datetime->getTimestamp()*1000 . ',' . $tmp['Valeur'] . ']';
			  		  else
			  		  {
			      		      $tempStr = '[' . $datetime->getTimestamp()*1000 . ',' . $tmp['Valeur'] . ']';
			      		      $bool = true;
			  		  }
		      		      }
		  		  }

		  		  $temperatures->closeCursor();
		  		  $temperatures->execute();
		  		  echo "{";
		  		  echo "id : '" . $data['Sonde_id'] ."',";
		  		  echo "name : '" . $data['Nom'] . "',";
		  		  echo "data : [" . $tempStr . "]";
		  		  echo "}";

		  		  ++$cpt;
		  		  if ($cpt < $nbSondes) echo ",";
				  
	      		      }

	      		      $result->closeCursor();
	      		      $result->execute();
	      		    */
		  		  ?>
	  		  ]
		      };

		      // Création du graphique
		      chart = new Highcharts.Chart(options);

		      //// CALLBACKS ////

		      // Coche/Decoche tout
		      $('#select_all').click( function () {
			  var cases = $("#baseSondes").find(':checkbox'); // on cherche les checkbox qui dépendent de la liste 'cases'

			  // si 'cocheTout' est coché
			  if(this.checked)
			  { 
			      //cases.attr('checked', false); // on coche les cases
			      //cases.trigger("click"); 
			      cases.each(function () {
				  if (!$(this).prop('checked'))
				  {
				      $(this).trigger("click");
				  }
			      });
			      $('#cocheText').html('Tout décocher'); // mise à jour du texte de cocheText
			  }
			  // si on décoche 'cocheTout' 
			  else
			  { 
			      //cases.attr('checked', true); // on décoche les cases
			      cases.each(function () {
				  if ($(this).prop('checked'))
				  {
				      $(this).trigger("click"); 
				  }
			      });
			      $('#cocheText').html('Cocher tout');// mise à jour du texte de cocheText
			  }         			    
		      });

		      // Checkboxes cochées
		      $('#baseSondes :checkbox').click(function () {
	  		  var idSonde = $(this).attr('id');
	  		  if ($(this).prop('checked'))
	  		  {
	      		      var traffic = [];      

	      		      $.get('scripts/fct.php?id=' + idSonde, null, function (tsv) {
		  		  try {
		      		      // split the data return into lines and parse them
		      		      tsv = tsv.split(/\n/g);
		      		      $.each(tsv, function(i, line) {
			  		  line = line.split(/\t/);

			  		  // Split timestamp into [ Y, M, D, h, m, s ]
			  		  var t = line[0].split(/[- :]/);

			  		  // Apply each element to the Date function
			  		  date = Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

			  		  if (line != "")
			  		  {
			      		      // On ajoute la valeur dans la liste des points
			      		      traffic.push([
					  	  date,
					  	  parseFloat(line[1].replace(',', ''), 10)
				      	      ]);
				  	  }
			      	      });   

			  	  } catch (e) {
			      	      alert("Nom: " + e.name + "\n" + "Message: " + e.message);
			  	  }

			  	  chart.addSeries({id: idSonde, name: $('#' + idSonde + ' + label').text(), data: traffic});
	      		      });

		  	  } 
			  else 
			  {
			      chart.get(idSonde.toString()).remove();
			  }
		      });

		      // Date de début changée
		      $('#debut').change(function () {

			  var d = $(this).val().split('/');
	  		  var nouvDate = Date.UTC(d[2], d[1]-1, d[0]);

	  		  var maDate = Highcharts.dateFormat("%Y-%m-%d %H:%M:%S", chart.xAxis[0].getExtremes().max);
	  		  var t = maDate.split(/[- :]/);
	  		  var dateF = Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

	  		  var maDate2 = Highcharts.dateFormat("%d/%m/%Y", chart.xAxis[0].getExtremes().min);

	  		  if (nouvDate >= dateF) {
	    		      alert("Date >= à la date de fin !");
	    		      $(this).val(maDate2);
	  		  }
	  		  else {
	    		      chart.xAxis[0].setExtremes(nouvDate, dateF);
	      		      chart.redraw();
	  		  }
		      });

		      // Date de fin changée
		      $('#fin').change(function () {
			  
			  var d = $(this).val().split('/');
			  var nouvDate = Date.UTC(d[2], d[1]-1, d[0]);

			  var maDate = Highcharts.dateFormat("%Y-%m-%d %H:%M:%S", chart.xAxis[0].getExtremes().min);
			  var t = maDate.split(/[- :]/);
			  var dateD = Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

			  var maDate2 = Highcharts.dateFormat("%d/%m/%Y", chart.xAxis[0].getExtremes().max);

			  if (nouvDate <= dateD) {
	    		      alert("Date <= à la date de début !");
	    		      $(this).val(maDate2);
	  		  } else {
	    		      chart.xAxis[0].setExtremes(dateD, nouvDate);
	    		      chart.redraw();
	  		  }
		      });
		  });

</script>
