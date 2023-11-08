<?php
if(($_SESSION['role']!=1)&&($_SESSION['role']!=3)){
	
    echo "<script>alert('Accès non autorisé. Vous avez été déconnecté.');window.location.href=\"index.php\";</script>";
}

if(!isset($_GET['action'])){
	$_GET['action'] = 'indexmoderateur';
}
$action = $_GET['action'];

switch($action){
	
	case 'indexmoderateur':{

        include("vues/v_sommaire.php");
		include("vues/v_moderateur.php");
		break;
	}

    case 'valideavis':{
        $idM=$_GET['idM'];
        $idV=$_GET['idV'];

        $valid=$pdo->valideavis($idM,$idV);
            echo "<script>alert('L\'avis a bien été validé')</script>";
            include("vues/v_sommaire.php");
            include("vues/v_moderateur.php");
		    break;
    }
}

?>