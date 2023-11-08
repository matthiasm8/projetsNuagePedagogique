<?php 

if(!isset($_GET['action'])){
	$_GET['action'] = 'listeproduits';
}
$action = $_GET['action'];
switch($action){
	
    case 'listeproduits':{
        include("vues/v_sommaire.php");
		include("vues/v_produits.php");
        break;
    }

    case 'info':{
        $idP=$_GET['id'];
        $idM=$_SESSION['id'];

        $pdo->vueProduit($idP,$idM);
    }

    case 'info':{
        $idP=$_GET['id'];
        $idM=$_SESSION['id'];

        $pdo->vueProduit($idP,$idM);
    }

    case 'aimer':{
        $idP=$_GET['id'];
        $idM=$_SESSION['id'];

        $pdo->aimerProduit($idP,$idM);
    }
}