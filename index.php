
<?php
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
require_once ("include/class.mail.php");
$mail =  new Mail();
session_start();



date_default_timezone_set('Europe/Paris');



$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
$db = PdoGsb::$monPdo;
    $sql=$db->prepare("SELECT etat FROM maintenance");
    $sql->execute();
    $med=$sql->fetch();

if(!isset($_GET['uc'])){
     $_GET['uc'] = 'connexion';
}
else {
    if($_GET['uc']=="connexion" && !estConnecte()){
        $_GET['uc'] = 'connexion';
    }
	if($_GET['uc']=="validation" && !estConnecte()){
        $_GET['uc'] = 'validation';
    }
        
}

$uc = $_GET['uc'];
switch($uc){
	case 'connexion':{
		include("controleurs/c_connexion.php");break;
	}
    case 'creation':{
		include("controleurs/c_creation.php");break;
	}
	case 'validation':{
		include("controleurs/c_validation.php");break;
	}
	case 'droits':{
		include("controleurs/c_droits.php");break;
	}
	case 'deconnexion':{
		include("controleurs/c_deconnexion.php");break;
	}
	case 'code':{
		include("controleurs/c_code.php");break;
	}
	case 'validateur':{
		include("controleurs/c_validateur.php");break;
	}
	case 'cdp':{
		include("controleurs/c_cdp.php");break;
	}
	case 'medecin':{
		include("controleurs/c_medecin.php");break;
	}
	case 'admin':{
		include("controleurs/c_admin.php");break;
	}
	case 'produits':{
		include("controleurs/c_produits.php");break;
	}
	case 'visios':{
		include("controleurs/c_visios.php");break;
	}
	case 'moderateur':{
		include("controleurs/c_moderateur.php");break;
	}
	
        
	
	}

require_once ("vues/v_footer.php");
	


?>







