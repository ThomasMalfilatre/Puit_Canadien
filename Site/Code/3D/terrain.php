<!doctype html>
<html lang="fr">
	<head>
		<title>Vue 3D sondes</title>
		<meta charset="utf-8">
	    <link rel=stylesheet href="../css/sonde3d.css"/>
	</head>
	<body>

		<script src="../scripts/THREE/Three.js"></script>
		<script src="../scripts/THREE/Detector.js"></script>
		<script src="../scripts/THREE/Stats.js"></script>
		<script src="../scripts/THREE/OrbitControls.js"></script>
		<script src="../scripts/THREE/THREEx.KeyboardState.js"></script>
		<script src="../scripts/THREE/THREEx.FullScreen.js"></script>
		<script src="../scripts/THREE/THREEx.WindowResize.js"></script>

		<div id="container" style="z-index: 1; position: absolute; left:0px; top:0px"></div>
		<script src="js/main.js"></script>
		<script src="js/placer_sonde.js"></script>
		<script src="js/placer_corbeille.js"></script>
		<script src="js/placer_puit.js"></script>

		<?php include 'pos_corbeille.php'; ?>
		<?php include 'pos_sonde.php'; ?>
		<?php echo "<script> placer_puit(); </script>"; ?>

	</body>
</html>