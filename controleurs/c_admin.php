<?php
if(($_SESSION['role']!=3)){
	
    echo "<script>alert('Accès non autorisé. Vous avez été déconnecté.');window.location.href=\"index.php\";</script>";
}

if(!isset($_GET['action'])){
	$_GET['action'] = 'indexAdmin';
}
$action = $_GET['action'];
switch($action){

    case 'indexAdmin':{
        include("vues/v_sommaire.php");
		include("vues/v_admin.php");
		break;
	}

    case 'planmaintenance':{
		include("vues/v_sommaire.php");
        include("vues/v_maintenance.php");
		break;
       
	}

	case 'logs':{
		include("vues/v_sommaire.php");
        include("vues/v_logs.php");
		break;
       
	}

	case 'statsproduits':{
		include("vues/v_sommaire.php");
        include("vues/v_statsproduits.php");
		break;
       
	}

	case 'listeproduits':{
		include("vues/v_sommaire.php");
        include("vues/v_produit.php");
		break;
       
	}

	case 'validemaintenance':{
        // $date = $_POST['date'];
		// $heure =$_POST['heure'];
		if ($pdo->Maintenance($med['etat'])){
			if ($med['etat']==0){echo "<script>alert('Maintenance activée.')</script>";}
			if ($med['etat']==1){echo "<script>alert('Maintenance stoppée !')</script>";}
			echo "<script>window.location.href=\"index.php\";</script>";break;
		}
       
	}


}