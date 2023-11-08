<?php


if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeCreation';
}
$action = $_GET['action'];
switch($action){
	
	case 'demandeCreation':{
		include("vues/v_creation.php");
		break;
	}
	case 'valideCreation':{
		


		$leLogin = strip_tags($_POST['login']);
        $lePassword = strip_tags($_POST['mdp']);
        $checkOk = strip_tags($_POST['checkbox']);
        $telephone = strip_tags($_POST['telephone']);
        $nom = strip_tags($_POST['nom']);
        $prenom = strip_tags($_POST['prenom']);
        $naiss = strip_tags($_POST['datenaiss']);
        $rpps = strip_tags($_POST['rpps']);
        $diplome = strip_tags($_POST['datediplome']);
        
        if ($leLogin == $_POST['login'])
        {
             $loginOk = true;
             $passwordOk=true;
        }
        else{
            echo 'tentative d\'injection javascript - login refusé';
             $loginOk = false;
             $passwordOk=false;
        }
        //test récup données
        //echo $leLogin.' '.$lePassword;
        $rempli=false;
        if ($loginOk && $passwordOk){
        //obliger l'utilisateur à saisir login/mdp
        $rempli=true;
        //if (testMail) 
        if (empty($leLogin)==true) {
            echo 'Le login n\'a pas été saisi<br/>';
            $rempli=false;
        }
        if (empty($lePassword)==true){
            echo 'Le mot de passe n\'a pas été saisi<br/>';
            $rempli=false; 
        }
        if ($checkOk!=1) {
            echo 'Vous n\'avez pas accepté notre politique de protection des données <br/>';
            $rempli=false;
        }
        
        
        //si le login et le mdp contiennent quelque chose
        // on continue les vérifications
        if ($rempli){
            //supprimer les espaces avant/après saisie
            $leLogin = trim($leLogin);
            $lePassword = trim($lePassword);

            

            //vérification de la taille du champs
            
            $nbCarMaxLogin = $pdo->tailleChampsMail();
            if(strlen($leLogin)>$nbCarMaxLogin){
                 echo 'Le login ne peut contenir plus de '.$nbCarMaxLogin.'<br/>';
                $loginOk=false;
                
            }

            //vérification doublon login bdd

            $verifMail = $pdo->testMail($leLogin);
            if ($verifMail==true){
                echo 'Un compte avec cette adresse mail existe déjà !';
                $loginOk=false;
            }        
        
            
            
            //vérification du format du login
           if (!filter_var($leLogin, FILTER_VALIDATE_EMAIL)) {
                echo 'le mail n\'a pas un format correct<br/>';
                $loginOk=false;
            }
            
          
            $patternPassword='#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W){12,}#';
            if (preg_match($patternPassword, $lePassword)==false){
                echo 'Le mot de passe doit contenir au moins 12 caractères, une majuscule,'
                . ' une minuscule et un caractère spécial<br/>';
                $passwordOk=false;
            }            
            
                 
        }
        }
        
        if($rempli && $loginOk && $passwordOk){
                $lePassword = password_hash($lePassword, PASSWORD_DEFAULT);
                $token=generateCode();
                $executionOK = $pdo->creeMedecin($leLogin, $lePassword, $prenom, $nom, $telephone, $naiss, $rpps, $diplome,$token);       
               
                if ($executionOK==true){
                    
                    $mail->envoiMail($token,$leLogin);
                    echo "<script>alert('Un mail de confirmation vous a été envoyé par mail.');
                          window.location.href=\"index.php?uc=validation&action=demandeValidation&mail=$leLogin\"</script>" ;
                    
                }   
                else
                     echo "ce login existe déjà, veuillez en choisir un autre";
                
                
            }
            
        break;	
}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>