<?php
if(!isset($_GET['action'])){
	$_GET['action'] = 'indexMedecin';
}
$action = $_GET['action'];
switch($action){

		case 'indexMedecin':{
            include("vues/v_sommaire.php");
            include("vues/v_medecin.php");
		break;
        }

        case 'accesProduit':{
            include("vues/v_sommaire.php");
            include("vues/v_produit.php");
		break;
        }

        case 'inscrirevisio':{
            include("vues/v_sommaire.php");
            include("vues/v_visio.php");
        break;
        }

        case 'mesvisio':{
            include("vues/v_sommaire.php");
            include("vues/v_mesvisio.php");
        break;
        }

        case 'DonneAvis':{
            include("vues/v_sommaire.php");
            include("vues/v_avisvisio.php");
        break;
        }
    }


?>