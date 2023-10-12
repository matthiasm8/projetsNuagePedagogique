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
		if(valideCode($token,$login)){
				$infosMedecin = $pdo->donneLeMedecinByMail($login);
				$id = $infosMedecin['id'];
				$nom =  $infosMedecin['nom'];
				$prenom = $infosMedecin['prenom'];
				connecter($id,$nom,$prenom);
				$pdo->ajouteConnexionInitiale($id);
				
						   
				include("vues/v_sommaire.php");
		}
    }
}