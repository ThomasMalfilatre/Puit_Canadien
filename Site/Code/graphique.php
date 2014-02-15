<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php
            include('block/head/head.php');
            include("admin/ConnexionBD.php");
            // include("scripts/chartScript.php"); // utilisation de highcharts
        ?>

        <link rel='stylesheet' type='text/css' href='css/graphique.css' />
        <link rel="stylesheet" href="css/jquery-ui.css" />
    
        <script src="scripts/jquery/jquery-1.9.1.min.js"></script>
        <script src="scripts/jquery/jquery-ui.js"></script>
        <script src="scripts/jquery/jquery-ui-i18n.min.js"></script>
        <script type="text/javascript" src="admin/menu.js"></script>
        <script type="text/javascript">      
            $(document).ready(function () {    
                $(function() {
                    $("#tabs").tabs({heightStyle: "auto"});
                });
            });
        </script>
    </head>
  
    <body>
        <?php include('block/body/header.php');?>

        <div id='contenu'>
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Température des sondes</a></li>
                    <!-- <li><a href="#tabs-2">Température par profondeur des sondes</a></li> -->
                    <li><a href="#tabs-3">Position des sondes</a></li>
                </ul>
                <div id="tabs-1">
                    <div id="ui">
                        <?php
                            // include('block/body/form.php');  // liste deroulante selection des sondes
                            include('block/body/graph.php'); // graphique
                            include('3D/terrain.php');
                        ?>
                    </div>
                </div>
                <div id="tabs-2">
                </div> 
                <div id="tabs-3">
                    <img src="data/sondes.png" alt="Positions des sondes" width="800px" height="400px"/>
                </div> 
            </div>
        </div>
        <?php include('block/body/footer.php');?>
    </body>
</html>
