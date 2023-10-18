<?php


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
        include("vues/v_maintenance.php");
		break;
       
	}

	case 'validemaintenance':{
        // $date = $_POST['date'];
		// $heure =$_POST['heure'];
		if ($pdo->Maintenance()){
			echo "<script>alert('Erreur image.')</script>";break;
		}
       
	}


}