<?php 

if(!isset($_GET['action'])){
	$_GET['action'] = 'portabilite';
}
$action = $_GET['action'];
switch($action){
	
	case 'portabilite':{
		include("vues/v_droits.php");
		break;
	}
    case 'telechargement':{
		$id=$_SESSION['id'];
        $a=$pdo->creefichierjson($id);
		file_put_contents("/var/www/html/projet/gsbextranetB3/portabilite/$id.json",$a);
    }
}

?>