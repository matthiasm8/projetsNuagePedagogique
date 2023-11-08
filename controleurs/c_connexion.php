<?php


if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeConnexion';
}
$action = $_GET['action'];
switch($action){
	
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
		$login = $_POST['login'];
		$mdp = $_POST['mdp'];

		$connexionOk = $pdo->checkUser($login,$mdp);
		if(!$connexionOk){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		else { 
			$valideOk=$pdo->checkValide($login);
			if (!$valideOk){
				ajouterErreur("Votre compte n\'a pas encore été validé !");
				include("vues/v_erreurs.php");
				include("vues/v_connexion.php");
			}
			else{

				$token=generateCode();
				$auth=$pdo->tokenCo($token,$login);
				if ($auth){
					echo "<script> alert('Veuillez entrer votre token de connexion reçu par mail.');</script>";
					$mail->envoiMail($token,$login);
					
				}
				include("vues/v_code.php");
			}
            
			}

			break;	
	}
       
        
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>