<?php
if(($_SESSION['role']!=5)&&($_SESSION['role']!=3)){
	
    echo "<script>alert('Accès non autorisé. Vous avez été déconnecté.');window.location.href=\"index.php\";</script>";
}

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

        case 'mesvisio':{
            include("vues/v_sommaire.php");
            include("vues/v_mesvisio.php");
        break;
        }

        case 'donneavis':{

            $idV=$_GET['id'];
            $idM=$_SESSION['id'];
            $avis=$_POST['avis'];

            $pdo->donneAvis($avis,$idM,$idV);
            echo "<script>alert('Votre avis a été enregistré !  Un modérateur va le vérifier afin de le rendre public.')</script>";

            include("vues/v_sommaire.php");
            include("vues/v_mesvisio.php");
        break;
        }

        case 'inscrirevisio':{
            $idV=$_GET['id'];
            $idM=$_SESSION['id'];

        $pdo->inscrireVisio($idM,$idV);
        echo "<script>alert('Vous êtes bien inscrit !')</script>";
            
        include("vues/v_sommaire.php");
        include("vues/v_visios.php");
        break;       
        }
    }


?>