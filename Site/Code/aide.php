<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php include('block/head/head.php'); ?>
        <link rel="stylesheet" type="text/css" href="css/doc.css">
    </head>
    <body>
        <?php include('block/body/header.php'); ?>

        <div id='contenu'>
            <?php include('doc/doc.html'); ?>
        </div>
        
        <?php include('block/body/footer.php'); ?>
    </body>
</html>
