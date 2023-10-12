<?php 

if(!isset($_GET['action'])){
	$_GET['action'] = 'portabilite';
}
$action = $_GET['action'];
switch($action){
	
    case 'consulter':{
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
}

?>
