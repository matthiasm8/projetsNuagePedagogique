<?php

if(!isset($_GET['action'])){
	$_GET['action'] = 'indexValidateur';
}
$action = $_GET['action'];

switch($action){
	
	case 'indexValidateur':{
        // $med=$pdo->listeAttente();
        // if ($med){
        //     $lesmed = array (
        //     "nom" => $med["nom"],
        //     "prenom" => $med["prenom"],
        //     "mail" => $med["mail"],
        //     "telephone" => $med["telephone"],
        //     "datenaissance" => $med["dateNaissance"],
        //     );
        // }
        include("vues/v_sommaire.php");
		include("vues/v_validateur.php");
		break;
	}

    case 'AccepteMedecin':{
        $id=$_GET['id'];
        $valid=$pdo->valideMedecin($id);
        if($valid){
            echo "<script>alert('Le médecin a bien été validé')</script>";
            include("vues/v_sommaire.php");
            include("vues/v_validateur.php");
		    break;
        }
        else 
        echo "<script>alert('Erreur lors de la validation.')</script>";
            include("vues/v_sommaire.php");
            include("vues/v_validateur.php");
		    break;
        
    }
}

?>