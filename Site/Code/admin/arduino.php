<?php
	$command = "echo \"F".$_POST["freq"]."\" > ../bin/ardumod";
	system($command);

	header("Location:../administration.php");
?>