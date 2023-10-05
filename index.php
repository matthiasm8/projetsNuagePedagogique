﻿
<?php
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
session_start();



date_default_timezone_set('Europe/Paris');



$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
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
	case 'droits':{
		include("controleurs/c_droits.php");break;
	}
        
	
	}
require_once ("vues/v_footer.php");
	


?>







