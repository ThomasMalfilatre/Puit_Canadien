<?php include('block/body/header.php');?>

<?php
	$pass = '0000';
?>
	
<p style="margin-top: 100px ; text-align: center">Veuillez entrer le mot de passe !</p>
		
<form style="text-align: center" action="#" method="post">
	<input type="password" name="pass" value=""/>		
	<input type="submit" value="Valider"/>
</form>
	
<?php
	if( isset($_POST['pass']) ){
	if ($_POST['pass'] == $pass)
		$_SESSION['pass'] = true;	 
	else{
		echo "<p style=\"margin-top: 20px ; text-align: center;font-size:16px;font-weight:bold;color:red\">Erreur de mot de passe...</p><br />";
		$_SESSION['pass'] = false;
		}
	}

	if ( !isset($_SESSION['pass']) ) {	$_SESSION['pass'] = false; }
	if ($_SESSION['pass'] == false){ exit;}
?>
