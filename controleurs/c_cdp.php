<?php


if(!isset($_GET['action'])){
	$_GET['action'] = 'consulter';
}
$action = $_GET['action'];
switch($action){

    case 'ajoutproduit':{
        include("vues/v_sommaire.php");
		include("vues/v_ajoutproduit.php");
		break;
	}

    case 'valideproduit':{
        $nom = $_POST['nom'];
		$objectif = $_POST['objectif'];
        $info=$_POST['info'];
        $effet=$_POST['effet'];
        $filename=str_replace(' ', '.',$_FILES['image']['name']);$filename=no_accent($filename);
        $targetPath="./images_produits/".$filename;
        if(!move_uploaded_file($filename,$targetPath)){
            echo "<script>alert('Erreur image.')</script>";break;
        }

        $pdo->ajoutProduit($nom,$objectif,$info,$effet,$filename);

       
	}


}