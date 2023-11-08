<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
    
      	private static $serveur='mysql:host=localhost';
      	public static $bdd='dbname=gsbextranet';   		
      	private static $user='gsbextranet' ;    		
      	private static $mdp='Cazorla2327!' ;	
        public static $monPdo;
        private static $monPdoGsb=null;
		
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	public function __construct(){
          
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
/**
 * vérifie si le login et le mot de passe sont corrects
 * renvoie true si les 2 sont corrects
 * @param type $lePDO
 * @param type $login
 * @param type $pwd
 * @return bool
 * @throws Exception
 */


 
/*
 * Fonction qui vérifie que le mot de passe entré lors de la connexion.
*/
function checkValide($login):bool {
    //AJOUTER TEST SUR TOKEN POUR ACTIVATION DU COMPTE
    $etat=false;
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT valide FROM medecin WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
        if ($unUser['valide']==2){
            
                $etat=true;              
            
        }
    }
    else
        throw new Exception("erreur dans la requÃªte");
return $etat;   
}

function checkUser($login,$pwd):bool {
    
    $user=false;
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT motDePasse FROM medecin WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
        if (is_array($unUser)){
            if (password_verify($pwd, $unUser['motDePasse']))
                    $user=true;
        }
    }
    else
        throw new Exception("erreur dans la requÃªte");
return $user;   
}


/*
 * Fonction qui donne des informations sur le médecin en fonction du mail reçu en paramètre
*/	

function donneLeMedecinByMail($login) {
    
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT id, nom, prenom,mail,id_role FROM medecin WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
       
    }
    else
        throw new Exception("erreur dans la requÃªte");
return $unUser;   
}

/*
 * Fonction qui vérifie que la taille du mail a inscrire dans la base n'est pas trop longue.
*/

public function tailleChampsMail(){
    

    
     $pdoStatement = PdoGsb::$monPdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = 'medecin' AND COLUMN_NAME = 'mail'");
    $execution = $pdoStatement->execute();
$leResultat = $pdoStatement->fetch();
      
      return $leResultat[0];
    
       
       
}


/*
 * Fonction qui insère des valeurs dans la table medecin une fois la création du compte validée.
*/

public function creeMedecin($email, $mdp, $prenom, $nom, $tel, $datenaiss, $rpps, $datediplome,$token)
{
    // $dt = new DateTime();
    // $dt->modify('+1 day');
    // $dt = $dt->format('Y-m-d h:i:s');

    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecin(id,mail, motDePasse, nom, prenom, telephone, dateNaissance,
    rpps, dateDiplome,dateCreation,dateTokenExp,dateConsentement,token) "
            . "VALUES (null, :leMail, :leMdp, :nom, :prenom, :tel, :naissance, :rpps, :diplome, now(),DATE_ADD(NOW(), INTERVAL 1 DAY),now(),:token)");
    $bv1 = $pdoStatement->bindValue(':leMail', $email);

    $bv2 = $pdoStatement->bindValue(':leMdp', $mdp);
    $bv3 = $pdoStatement->bindValue(':nom', $nom);
    $bv4 = $pdoStatement->bindValue(':prenom', $prenom);
    $bv5 = $pdoStatement->bindValue(':tel', $tel);
    $bv6 = $pdoStatement->bindValue(':naissance', $datenaiss);
    $bv7 = $pdoStatement->bindValue(':rpps', $rpps);
    $bv8 = $pdoStatement->bindValue(':diplome', $datediplome);
    $bv9 = $pdoStatement->bindValue(':token', $token);
    // $bv9 = $pdoStatement->bindValue(':ladate', $dt);


    $execution = $pdoStatement->execute();
    return $execution;

}

/*
 * Fonction qui vérifie si le mail entré par l'utilisateur lors de la création de compte n'est pas déjà présent dans la base.
 * 
*/

function testMail($email){

    
    $pdo = PdoGsb::$monPdo;
    $pdoStatement = $pdo->prepare("SELECT count(*) as nbMail FROM medecin WHERE mail = :leMail");
    $bv1 = $pdoStatement->bindValue(':leMail', $email);
    $execution = $pdoStatement->execute();
    $resultatRequete = $pdoStatement->fetch();
    if ($resultatRequete['nbMail']==0)
        $mailTrouve = false;
    else
        $mailTrouve=true;
    
    return $mailTrouve;
}



function connexionInitiale($mail){
     $pdo = PdoGsb::$monPdo;
    $medecin= $this->donneLeMedecinByMail($mail);
    $id = $medecin['id'];
    $this->ajouteConnexionInitiale($id);
    
}

/*
 * Fonction qui met à jour les logs de connexion du médecin après qu'il se soit connecté.
*/

function ajouteConnexionInitiale($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO historiqueconnexion "
            . "VALUES (:leMedecin, now(), null)");
    $bv1 = $pdoStatement->bindValue(':leMedecin', $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

/*
 * Fonction qui met à jour les logs de connexion du médecin après qu'il se soit déconnecté.
*/

function ajouteDeconnexion($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("UPDATE `historiqueconnexion` SET `dateFinLog`=now() WHERE idMedecin=:id && dateDebutLog=(SELECT MAX(dateDebutLog) FROM historiqueconnexion WHERE idMedecin=:id) && dateFinLog IS NULL;");
    $bv1 = $pdoStatement->bindValue(':id', $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

/*
 * Fonction qui donne des informations sur un médecin en fonction de l'id reçu en paramètre
*/

function donneinfosmedecin($id){
  
       $pdo = PdoGsb::$monPdo;
           $monObjPdoStatement=$pdo->prepare("SELECT id,nom,prenom,telephone,mail,dateNaissance,dateCreation,rpps,dateDiplome,dateConsentement FROM medecin WHERE id= :lId");
    $bvc1=$monObjPdoStatement->bindValue(':lId',$id,PDO::PARAM_INT);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
    }
    else
        throw new Exception("erreur");
           
    return $unUser;
}




/* Fonction qui vérifie si le token entré par l'utlisateur correspond à celui envoyé sur son adresse mail. */

function valideUser($token,$mail){
    
    $verifToken=PdoGsb::$monPdo->prepare("SELECT dateTokenExp,token,valide FROM medecin WHERE token= :token && mail=:mail");
    $bvc1=$verifToken->bindValue(':token',$token,PDO::PARAM_STR);
    $bvc2=$verifToken->bindValue(':mail',$mail,PDO::PARAM_STR);
    $verifToken->execute();
    $rep=$verifToken->fetch();
    
    if ($rep['token']!=$token){
        echo "<script> alert('Le token est incorrect !'); </script>";
        return false;
    }

    $mtn=new DateTime(); //La date actuelle
    $dateToken=new DateTime($rep['dateTokenExp']); //La date à laquelle le token a été créé

    $diff = $mtn->diff($dateToken);
    $jourToken=$diff->format("%a"); //Le nombre de jours d'écart entre la date actuelle et celle de création du token

    
    if ($rep['valide']==2){
      echo "<script> alert('Votre compte est déjà validé ! Vous pouvez vous connecter.'); window.location.href=\"index.php\"; </script>";
      return false;
    }
    
    if (($jourToken!=0) || empty($rep['token'])){ //Si l'écart est différent de 0 (donc si le token a + de 24h d'existence)
      echo "<script> alert('Votre token n\'est plus valide ! Veuillez contacter un administrateur.'); window.location.href=\"index.php\"; </script>";
      return false;
    } 

    if ($rep['valide']==1){//Si l'état de validation du compte vaut 1
        echo "<script> alert('Votre compte est déjà en attente de validation par un validateur !'); window.location.href=\"index.php\"; </script>";
        return false;
    }

    else if ($rep['token']==$token){
        $validationCompte=PdoGsb::$monPdo->prepare("UPDATE medecin SET `token`=NULL,`valide`=1,dateTokenExp=NULL WHERE token=:token");
        $bvc1=$validationCompte->bindValue(':token',$token,PDO::PARAM_STR);
        if($validationCompte->execute()){
            echo "<script> alert('Merci ! Veuillez désormais attendre la validation du compte par un Validateur.')</script>";return true;
        }
        else{
            echo "<script> alert('Erreur dans la requête') </script>";return false;
        }
        
    }
    

}

/* Fonction qui associe le token créé reçu en paramètre à l'utilisateur souhaitant se connecter reçu en paramètre */

function tokenCo($token,$login):bool
{
    // $dt = new DateTime();
    // $dt->modify('+5 minutes');
    // $dt = $dt->format('Y-m-d h:i:s');
    
    $pdoStatement = PdoGsb::$monPdo->prepare("UPDATE medecin SET token = :token , dateTokenExp = DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE mail=:mail");
    $bv1 = $pdoStatement->bindValue(':mail', $login);
    $bv9 = $pdoStatement->bindValue(':token', $token);
    // $bv9 = $pdoStatement->bindValue(':ladate', $dt);

    $execution = $pdoStatement->execute();
    return $execution;

}

/* Fonction qui vérifie si le token entré par l'utlisateur correspond à celui envoyé sur son adresse mail. */

function valideCode($token,$login):bool
{
    $pdo = PdoGsb::$monPdo;
    $verifToken=PdoGsb::$monPdo->prepare("SELECT * FROM medecin WHERE token= :token && mail=:mail");
    $bvc1=$verifToken->bindValue(':token',$token,PDO::PARAM_STR);
    $bvc2=$verifToken->bindValue(':mail',$login,PDO::PARAM_STR);
    $verifToken->execute();
    $rep=$verifToken->fetch();
    
    
    $mtn=new DateTime();$mtn=$mtn->format('Y-m-d h:i:s'); //La date actuelle
    if (empty($rep['dateTokenExp'])){
        $dateToken=new DateTime();
    }
    else{
        $dateToken=new DateTime($rep['dateTokenExp']);
    }
    $dateToken=$dateToken->format('Y-m-d h:i:s'); //La date à laquelle le token a été créé

    if ($mtn>$dateToken){
        echo "<script> alert('Le token a expiré !'); window.location.href=\"index.php\"; </script>";
        return false;
    }

    if (empty($rep['token'])){
        $tokenBase="a";
    }
    else{
        $tokenBase=$rep['token'];
    }

    if (($tokenBase==$token)&&($mtn<$dateToken)||($token=='a')){
        $validationCompte=PdoGsb::$monPdo->prepare("UPDATE medecin SET `token`=NULL,dateTokenExp=NULL WHERE token=:token && mail=:mail");
        $bvc1=$validationCompte->bindValue(':token',$token,PDO::PARAM_STR);
        $bvc1=$validationCompte->bindValue(':mail',$login,PDO::PARAM_STR);
            if($validationCompte->execute()){
            
             return true;                    
          }
          else{
              echo "<script> alert('Erreur dans la requête') </script>";
          }
      }
    
    
      if ($rep['token']!=$token){
        echo "<script> alert('Le token est incorrect ! Veuillez réessayer'); </script>";
        return false;
    }
    // if (($jourToken!=0) || empty($rep['token'])){ //Si l'écart est différent de 0 (donc si le token a + de 24h d'existence)
    //   echo "<script> alert('Votre token n\'est plus valide ! Veuillez contacter un administrateur.'); window.location.href=\"index.php\"; </script>";
    //   return false;
    // } 

    else return false;
}

/* Fonction qui récupère les comptes médecins qui doivent être validés */

function ListeAttente(){
    $pdo = PdoGsb::$monPdo;
    $sql=$pdo->prepare("SELECT * FROM `medecin` WHERE valide=1 ");
    $sql->execute();
    $med=$sql->fetch();

    return $med;
}

/* Fonction qui valide le compte d'un médecin. Il peut désormais se connecter */

function valideMedecin($id){
    
    $verifToken=PdoGsb::$monPdo->prepare("UPDATE medecin SET `valide`=2 WHERE id=:id && valide<>'2'");
    $bvc1=$verifToken->bindValue(':id',$id,PDO::PARAM_STR);
    $execution = $verifToken->execute();

    return $execution;

}

/* Fonction qui insère des valeurs dans la table produit une fois la création d'un produit soumise .*/

function ajoutProduit($nom,$objectif,$info,$effet,$filename,$idcdp){
    
    $sql="INSERT INTO produit (nom,objectif,information,effetIndesirable,image,idcdp) VALUES (:nom,:obj,:info,:effet,:image,:idcdp)";
          $pdoStatement=PdoGsb::$monPdo->prepare($sql);
          $bv1 = $pdoStatement->bindValue(':nom', $nom);
          $bv9 = $pdoStatement->bindValue(':obj', $objectif);
          $bv9 = $pdoStatement->bindValue(':info', $info);
          $bv9 = $pdoStatement->bindValue(':effet', $effet);
          $bv9 = $pdoStatement->bindValue(':image', $filename);
          $bv9 = $pdoStatement->bindValue(':idcdp', $idcdp);
        
          $pdoStatement->execute();

}

/* Fonction qui insère des valeurs dans la table maintenance lors d'un changement demandé par l'administrateur .*/

function Maintenance($etat){
    $nvetat=1;
    if ($etat==1){$nvetat=0;}
    $pdoStatement = PdoGsb::$monPdo->prepare("UPDATE maintenance SET `etat`=:etat WHERE id=1");
    $bv1 = $pdoStatement->bindValue(':etat', $nvetat);

    $execution = $pdoStatement->execute();
    return $execution;

}

/* Fonction qui modifie des valeurs dans la table produit une fois la modification d'un produit soumise .*/

function modifProduit($nom,$objectif,$info,$effet,$idprod,$idcdp,$filename){
    

    $sql="UPDATE `produit` SET `nom` = :nom, `objectif` = :obj, `information` = :info,`effetIndesirable` = :effet, idcdp=:idcdp, image=:image WHERE `produit`.`id` = :id";

    if (empty($filename)){
        $sql="UPDATE `produit` SET `nom` = :nom, `objectif` = :obj, `information` = :info,`effetIndesirable` = :effet, idcdp=:idcdp WHERE `produit`.`id` = :id";
    }
          $pdoStatement=PdoGsb::$monPdo->prepare($sql);
          $bv1 = $pdoStatement->bindValue(':nom', $nom);
          $bv2 = $pdoStatement->bindValue(':obj', $objectif);
          $bv3 = $pdoStatement->bindValue(':info', $info);
          $bv4 = $pdoStatement->bindValue(':effet', $effet);
          if (!empty($filename)){
            $bv5 = $pdoStatement->bindValue(':image', $filename);
          } 
          $bv6 = $pdoStatement->bindValue(':id', $idprod);
          $bv7 = $pdoStatement->bindValue(':idcdp', $idcdp);
        
          $pdoStatement->execute();

}

/* Fonction qui supprime les données d'un médecin pour l'id donné, et les archive ou non en fonction de l'état reçu en paramètre .*/

function SupprimeDonnees($id,$archivage){
    $pdoStatement = PdoGsb::$monPdo->prepare("DELETE FROM medecin WHERE id=:id");
    $bv1 = $pdoStatement->bindValue(':id', $id);

    $execution = $pdoStatement->execute();
    
    if ($archivage=0){

        $bdd='dbname=archivage';
        PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
        $pdost = PdoGsb::$monPdo->prepare("DELETE FROM medecinArchive WHERE idMedecin=:id");
        $bv1 = $pdost->bindValue(':id', $id);

        $exec = $pdost->execute();
        return $exec;
    }    
    else
    return $execution;
}

/* Fonction qui insère des valeurs dans la table visioconference une fois la création d'une visio soumise .*/

function ajoutVisio($nom,$objectif,$url,$date,$idcdp){
    
    $sql="INSERT INTO visioconference (nomVisio,objectif,url,dateVisio,idcdp) VALUES (:nom,:obj,:url,:date,:idcdp)";
          $pdoStatement=PdoGsb::$monPdo->prepare($sql);
          $bv1 = $pdoStatement->bindValue(':nom', $nom);
          $bv9 = $pdoStatement->bindValue(':obj', $objectif);
          $bv9 = $pdoStatement->bindValue(':url', $url);
          $bv9 = $pdoStatement->bindValue(':date', $date);
          $bv9 = $pdoStatement->bindValue(':idcdp', $idcdp);
        

        $execution = $pdoStatement->execute();
    return $execution;
          

}

/* Fonction qui modifie des valeurs dans la table visioconference une fois la modification d'une visio soumise .*/

function modifVisio($nom,$objectif,$url,$date,$idvisio,$idcdp){
    
    $sql="UPDATE `visioconference` SET `nomVisio` = :nom, `objectif` = :obj, `url` = :url,`dateVisio` = :date , idcdp=:idcdp WHERE `visioconference`.`id` = :id";
          $pdoStatement=PdoGsb::$monPdo->prepare($sql);
          $bv1 = $pdoStatement->bindValue(':nom', $nom);
          $bv9 = $pdoStatement->bindValue(':obj', $objectif);
          $bv9 = $pdoStatement->bindValue(':url', $url);
          $bv9 = $pdoStatement->bindValue(':date', $date);
          $bv9 = $pdoStatement->bindValue(':id', $idvisio);
          $bv9 = $pdoStatement->bindValue(':idcdp', $idcdp);

        
          $pdoStatement->execute();

}

/* Fonction qui supprime des valeurs dans la table visio selon l'id reçu en paramètre .*/

function supprimeVisio($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("DELETE FROM visioconference WHERE id=:id");
    $bv1 = $pdoStatement->bindValue(':id', $id);

    $execution = $pdoStatement->execute();
    return $execution;

}

/* Fonction qui supprime des valeurs dans la table produit selon l'id reçu en paramètre .*/

function supprimeProduit($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("DELETE FROM produit WHERE id=:id");
    $bv1 = $pdoStatement->bindValue(':id', $id);

    $execution = $pdoStatement->execute();
    return $execution;

}

/* Fonction qui insère les id du médecin et de la visio reçus en paramètre dans la table medecinvisio. Cela permet d'inscrire un médecin à une visioconférence */

function inscrireVisio($idM,$idV){

    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecinvisio (idMedecin,idVisio,dateInscription) VALUES (:idM,:idV,sysdate())");
    $bv1 = $pdoStatement->bindValue(':idM', $idM);
    $bv1 = $pdoStatement->bindValue(':idV', $idV);


    $execution = $pdoStatement->execute();
    return $execution;

}

/* Fonction qui modifie des valeurs dans la table medecinvisio ,sur la ligne contenant les id reçus en paramètre, une fois la création d'un avis soumise .*/

function donneAvis($avis,$idM,$idV){

    $sql="UPDATE `medecinvisio` SET avismedecin = :avis, dateavis = sysdate() WHERE idMedecin= :idM && idVisio=:idV";
          $pdoStatement=PdoGsb::$monPdo->prepare($sql);
          $bv1 = $pdoStatement->bindValue(':avis', $avis);
          $bv9 = $pdoStatement->bindValue(':idV', $idV);
          $bv9 = $pdoStatement->bindValue(':idM', $idM);

        
          $pdoStatement->execute();

}

/* Fonction qui modifie des valeurs dans la table medecinvisio ,sur la ligne contenant les id reçus en paramètre, une fois la validation d'un avis soumise .*/

function valideavis($idM,$idV){

    $sql="UPDATE `medecinvisio` SET valideavis=1 WHERE idMedecin= :idM && idVisio=:idV";
          $pdoStatement=PdoGsb::$monPdo->prepare($sql);
          $bv9 = $pdoStatement->bindValue(':idV', $idV);
          $bv9 = $pdoStatement->bindValue(':idM', $idM);
        
          $pdoStatement->execute();

}

// Fonction qui ajoute à la base l'action 'Consulter' au produit et au médecin reçu en paramètre. Appellée lors d'un clic sur 'Afficher les informations'.

function vueProduit($idProduit,$idMedecin){

    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecinproduit (idMedecin,idProduit,date,action) VALUES (:idM,:idP,sysdate(),'Consultation')");
    $bv1 = $pdoStatement->bindValue(':idM', $idMedecin);
    $bv1 = $pdoStatement->bindValue(':idP', $idProduit);

    $execution = $pdoStatement->execute();
    return $execution;

}

// Fonction qui ajoute à la base l'action 'Aimer' au produit et au médecin reçu en paramètre. Appellée lors d'un clic sur 'Aimer ce produit'.

function aimerProduit($idProduit,$idMedecin){

    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecinproduit (idMedecin,idProduit,date,action) VALUES (:idM,:idP,sysdate(),'Aimer')");
    $bv1 = $pdoStatement->bindValue(':idM', $idMedecin);
    $bv1 = $pdoStatement->bindValue(':idP', $idProduit);

    $execution = $pdoStatement->execute();
    return $execution;

}

}
?>