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
				$infosMedecin = $pdo->donneLeMedecinByMail($login);
				$id = $infosMedecin['id'];
				$nom =  $infosMedecin['nom'];
				$prenom = $infosMedecin['prenom'];
				$role = $infosMedecin['id_role'];
				$_SESSION['mail'] = $infosMedecin['mail'];
				$_SESSION['role']=$role;

				// $token=generateCode();
				// $auth=$pdo->tokenCo($token,$_SESSION['mail']);
				// if ($auth){
				// 	echo "<script> alert('Veuillez entrer votre token de connexion reçu par mail.');</script>";
				// 	$mail->envoiMail($token,$login);
					
				// }
				// include("vues/v_code.php");

				
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

			break;	
	}
       
        
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>