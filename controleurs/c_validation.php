<?php

if(!isset($_GET['action'])){
	$_GET['action'] = 'validationCompte';
}
$action = $_GET['action'];
switch($action){
	
	case 'demandeCreation':{
		include("vues/v_creation.php");
		break;
	}
	case 'validationCompte':{
		
    $token = htmlspecialchars($_POST['token']);
    valideUser($token);
    }
}

?>