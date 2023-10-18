<?php


if(!isset($_GET['action'])){
	$_GET['action'] = 'ajoutCode';
}
$action = $_GET['action'];
switch($action){
	
	case 'ajoutCode':{
		include("vues/v_code.php");
		break;
	}
	case 'valideCode':{
		$token = $_POST['token'];
		$login =$_SESSION['mail'];
		if($pdo->valideCode($token,$login)){
				$infosMedecin = $pdo->donneLeMedecinByMail($login);
				$id = $infosMedecin['id'];
				$nom =  $infosMedecin['nom'];
				$prenom = $infosMedecin['prenom'];
				connecter($id,$nom,$prenom);
				$pdo->ajouteConnexionInitiale($id);
				
						   
				include("vues/v_sommaire.php");
				switch($_SESSION['role']){
					case 5:{
						include("vues/v_medecin.php");
						break;
				    }  
					case 4:{
						include("vues/v_validateur.php");
						break;
					}  
					case 3:{
						include("vues/v_admin.php");
						break;
					}  
					case 2:{
						include("vues/v_cdp.php");
						break;
					}   
					case 1:{
						include("vues/v_moderateur.php");
						break;
					}            
				}
		}
    }
}