<?php 

if(!isset($_GET['action'])){
	$_GET['action'] = 'listevisios';
}
$action = $_GET['action'];
switch($action){
	
    case 'listevisios':{
        include("vues/v_sommaire.php");
		include("vues/v_visios.php");
    }
}