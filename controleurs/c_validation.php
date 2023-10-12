<?php

if(!isset($_GET['action'])){
	$_GET['action'] = 'validationCompte';
}
$action = $_GET['action'];
$mail = $_GET['mail'];
switch($action){
	
	case 'demandeValidation':{
		include("vues/v_validation.php");
		break;
	}
	case 'validationCompte':{
	
    $token = htmlspecialchars($_POST['token']);
    valideUser($token,$mail);
    }
}

?>