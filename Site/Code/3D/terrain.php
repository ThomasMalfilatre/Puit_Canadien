<!doctype html>
<html lang="fr">
	<head>
		<title>Vue 3D sondes</title>
		<meta charset="utf-8">
	    <link rel=stylesheet href="css/sonde3d.css"/>
	</head>
	<body>

		<script src="scripts/THREE/Three.js"></script>
		<script src="scripts/THREE/Detector.js"></script>
		<script src="scripts/THREE/Stats.js"></script>
		<script src="scripts/THREE/OrbitControls.js"></script>
		<script src="scripts/THREE/THREEx.KeyboardState.js"></script>
		<script src="scripts/THREE/THREEx.FullScreen.js"></script>
		<script src="scripts/THREE/THREEx.WindowResize.js"></script>

		<div id="container" style="z-index: 1; position: absolute; left:300px; right:50px; top:100px; bottom:100px"></div>
		<script src="3D/js/main.js"></script>
		<script src="3D/js/placer_sonde.js"></script>
		<script src="3D/js/placer_corbeille.js"></script>
		<script src="3D/js/placer_puit.js"></script>

		<?php include 'pos_corbeille.php'; ?>
		<?php include 'pos_sonde.php'; ?>
		<?php echo "<script> placer_puit(); </script>"; ?>

	</body>
</html>