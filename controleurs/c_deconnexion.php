<?php


if(!isset($_GET['action'])){
	$_GET['action'] = 'deconnexion';
}
$action = $_GET['action'];
switch($action){

    case 'deconnexion':
        $id=$_SESSION['id'];
        $pdo->ajouteDeconnexion($id);
        session_destroy();
        header("Location: index.php");
}