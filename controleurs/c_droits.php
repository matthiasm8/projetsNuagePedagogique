<?php 

if(!isset($_GET['action'])){
	$_GET['action'] = 'index';
}
$action = $_GET['action'];
switch($action){
	
    case 'footer':{
        include("vues/v_sommaire.php");
		include("vues/v_politiqueprotectiondonnees.php");
    }

    case 'index':{
        include("vues/v_sommaire.php");
		include("vues/v_droits.php");
        $id=$_SESSION['id'];
        $lesdonnes = $pdo->donneinfosmedecin($_SESSION['id']);
        $lesdonnestableau = array (
            "nom" => $lesdonnes["nom"],
            "prenom" => $lesdonnes["prenom"],
            "mail" => $lesdonnes["mail"],
            "telephone" => $lesdonnes["telephone"],
            "datenaissance" => $lesdonnes["dateNaissance"],

        );
        $donnesjson = json_encode($lesdonnestableau);
		file_put_contents("/var/www/html/projet/gsbextranetB3/portabilite/".$lesdonnes['id'].".json", $donnesjson);
		break;
    }

    case 'supprimer':{
        $id=$_SESSION['id'];
        $archivage=0;
        $pdo->SupprimeDonnees($id,$archivage);
            
            session_destroy();echo '<script>alert("Au revoir ma belle !");window.location.href=\"index.php\";</script>';
        
    }

    case 'archiver':{
        $id=$_SESSION['id'];
        $archivage=1;
        $pdo->SupprimeDonnees($id,$archivage);
            
            session_destroy();echo '<script>alert("Au revoir ma belle !");window.location.href=\"index.php\";</script>';
        
    }
}

?>
