<?php

if(!isset($_GET['action'])){
	$_GET['action'] = 'validationCompte';
}
$action = $_GET['action'];
$email = $_GET['mail'];
switch($action){
	
	case 'demandeValidation':{
		include("vues/v_validation.php");
		break;
	}
	case 'validationCompte':{
	
    $token = strip_tags($_POST['token']);
    if($pdo->valideUser($token,$email)){
	$infosMedecin = $pdo->donneLeMedecinByMail($email);
				$id = $infosMedecin['id'];
				$nom =  $infosMedecin['nom'];
				$prenom = $infosMedecin['prenom'];
				$role = $infosMedecin['id_role'];
	$mail->envoiMailValidateur($prenom,$nom);
	echo "<script>window.location.href=\"index.php\";</script>";}
    }
}

?>