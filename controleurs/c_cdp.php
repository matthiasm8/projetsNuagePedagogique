<?php
if(($_SESSION['role']!=2)&&($_SESSION['role']!=3)){
	
    echo "<script>alert('Accès non autorisé. Vous avez été déconnecté.');window.location.href=\"index.php\";</script>";
}

if(!isset($_GET['action'])){
	$_GET['action'] = 'indexCdp';
}
$action = $_GET['action'];
switch($action){

    case 'indexCdp':{
        include("vues/v_sommaire.php");
		include("vues/v_cdp.php");
		break;
	}

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
        $idcdp=$_SESSION['id'];
        $filename=str_replace(' ', '.',$_FILES['image']['name']);$filename=no_accent($filename);
        $imageTempName=$_FILES['image']['tmp_name'];
        $targetPath="/var/www/html/projet/gsbextranetB3/images_produits/".$filename;
        if (!empty($_FILES['image']['tmp_name'])){
            if(!move_uploaded_file($imageTempName,$targetPath)){
                echo "<script>alert('Erreur lors de la sauvegarde de l\'image.')</script>";break;
            }
        }        

        $pdo->ajoutProduit($nom,$objectif,$info,$effet,$filename,$idcdp);
        echo "<script>alert('Le produit a bien été créé !')</script>";
        include("vues/v_sommaire.php");
        include("vues/v_produits.php");
        break;

       
	}

    case 'modifieproduit':{
        include("vues/v_sommaire.php");
        include("vues/v_modifproduit.php");
        break;       
	}

    case 'validemodifproduit':{

        $nom = $_POST['nom'];
		$objectif = $_POST['objectif'];
        $info=$_POST['info'];
        $effet=$_POST['effet'];
        $idprod=$_GET['id'];
        $idcdp=$_SESSION['id'];
        $filename=str_replace(' ', '.',$_FILES['image']['name']);$filename=no_accent($filename);
        $imageTempName=$_FILES['image']['tmp_name'];
        $targetPath="/var/www/html/projet/gsbextranetB3/images_produits/".$filename;
        if (!empty($_FILES['image']['tmp_name'])){
            if(!move_uploaded_file($imageTempName,$targetPath)){
                echo "<script>alert('Erreur lors de la sauvegarde de l\'image.')</script>";break;
            }
        }        

        $pdo->modifProduit($nom,$objectif,$info,$effet,$idprod,$idcdp,$filename);
        echo "<script>alert('Le produit a bien été modifié !')</script>";

        include("vues/v_sommaire.php");
        include("vues/v_produits.php");
        break;       
	}

    case 'ajoutvisio':{
        include("vues/v_sommaire.php");
		include("vues/v_ajoutvisio.php");
		break;
	}

    case 'validevisio':{
        $nom = $_POST['nom'];
		$objectif = $_POST['objectif'];
        $url=$_POST['url'];
        $date=$_POST['date'];
        $idcdp=$_SESSION['id'];

        $pdo->ajoutVisio($nom,$objectif,$url,$date,$idcdp);
        echo "<script>alert('La visioconférence a bien été créée !')</script>";
        include("vues/v_sommaire.php");
        include("vues/v_visios.php");
        break;
	}

    case 'validemodifvisio':{

        $nom = $_POST['nom'];
		$objectif = $_POST['objectif'];
        $url=$_POST['url'];
        $date=$_POST['date'];
        $idvisio=$_GET['id'];
        $idcdp=$_SESSION['id'];

        $pdo->modifVisio($nom,$objectif,$url,$date,$idvisio,$idcdp);
        echo "<script>alert('La visio a bien été modifiée !')</script>";

        include("vues/v_sommaire.php");
        include("vues/v_visios.php");
        break;       
	}

    case 'modifievisio':{

        include("vues/v_sommaire.php");
        include("vues/v_modifvisio.php");
        break;    
	}

    case 'supprimevisio':{

        $idvisio=$_GET['id'];
        $pdo->supprimeVisio($idvisio);
        echo "<script>alert('La visio a bien été supprimée !')</script>";

        include("vues/v_sommaire.php");
        include("vues/v_visios.php");
        break;    
	}

    case 'supprimeproduit':{

        $idprod=$_GET['id'];
        $pdo->supprimeProduit($idprod);
        echo "<script>alert('Le produit a bien été supprimé !')</script>";

        include("vues/v_sommaire.php");
        include("vues/v_produits.php");
        break;    
	}
    

}