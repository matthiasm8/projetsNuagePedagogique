<?php
use phpmailer\phpmailer\phpmailer;
use phpmailer\phpmailer\Exception;
require_once 'phpmailer/src/Exception.php';
require_once 'phpmailer/src/PHPMailer.php';
require_once 'phpmailer/src/SMTP.php';
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
      	private static $bdd='dbname=gsbextranet';   		
      	private static $user='gsbextranet' ;    		
      	private static $mdp='Cazorla2327!' ;	
	public static $monPdo;
	private static $monPdoGsb=null;
		
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct(){
          
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
    //AJOUTER TEST SUR TOKEN POUR ACTIVATION DU COMPTE
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
    $monObjPdoStatement=$pdo->prepare("SELECT id, nom, prenom,mail FROM medecin WHERE mail= :login");
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
    $dt = new DateTime();
    $dt->modify('+1 day');
    $dt = $dt->format('Y-m-d h:i:s');

    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecin(id,mail, motDePasse, nom, prenom, telephone, dateNaissance,
    rpps, dateDiplome,dateCreation,dateTokenExp,dateConsentement,token) "
            . "VALUES (null, :leMail, :leMdp, :nom, :prenom, :tel, :naissance, :rpps, :diplome, now(),:ladate,now(),:token)");
    $bv1 = $pdoStatement->bindValue(':leMail', $email);

    $bv2 = $pdoStatement->bindValue(':leMdp', $mdp);
    $bv3 = $pdoStatement->bindValue(':nom', $nom);
    $bv4 = $pdoStatement->bindValue(':prenom', $prenom);
    $bv5 = $pdoStatement->bindValue(':tel', $tel);
    $bv6 = $pdoStatement->bindValue(':naissance', $datenaiss);
    $bv7 = $pdoStatement->bindValue(':rpps', $rpps);
    $bv8 = $pdoStatement->bindValue(':diplome', $datediplome);
    $bv9 = $pdoStatement->bindValue(':token', $token);
    $bv9 = $pdoStatement->bindValue(':ladate', $dt);


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

/* Fonction qui envoie un token de vérification de 6 caractères à l'adresse mail indiquée. */

function envoiMail($token,$lelogin){
    $mail = new PHPMailer(true);

    $mail->isSMTP();$mail->Host = 'smtp.gmail.com';$mail->SMTPAuth=true;
    $mail->Username='balavoinedev@gmail.com';$mail->Password='kdsgrpkdmszivmfr';
    $mail->SMTPSecure='ssl';$mail->Port=465;$mail->IsHTML(true);$mail->CharSet = "utf-8";

    $mail->setFrom('balavoinedev@gmail.com');

    /*$mail->addAddress($_POST['login']);*/
    $mail->addAddress('matthias.muyl@gmail.com');
 
    $mail->Subject = "Confirmez votre inscription à GSB Extranet";

    // $mail->Body = file_get_contents("templatemail.php");

    $mail->Body ='<a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=validation&action=demandeValidation&mail='.$lelogin.'" target="_blank">ici</a>'.$token.'';

    $mail->send();
    echo "<script>alert('Un mail de confirmation vous a été envoyé par mail.');
    window.location.href=\"index.php?uc=validation&action=demandeValidation&mail=$lelogin\"</script>" ;
    // header('Location: index.php?uc=validation&action=demandeValidation&mail='.$lelogin.'');

}

}

function envoiMailValidateur(){
    
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth=true;
    $mail->Username='balavoinedev@gmail.com';
    $mail->Password='kdsgrpkdmszivmfr';
    $mail->SMTPSecure='ssl';
    $mail->Port=465;
    $mail->IsHTML(true);
    $mail->CharSet = "utf-8";



    $mail->setFrom('balavoinedev@gmail.com');
    
    /*$mail->addAddress($_POST['login']);*/
    $mail->addAddress('matthias.muyl@gmail.com');
 
    $mail->Subject = "Confirmez votre inscription à GSB Extranet";
    
    // $mail->Body = file_get_contents("templatemail.php");

    $mail->Body ='<a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=validation&action=demandeValidation&mail='.$lelogin.'" target="_blank">ici</a>'.$token.'';

    $mail->send();
    echo "<script>alert('Un mail de confirmation vous a été envoyé par mail.');
    window.location.href=\"index.php?uc=validation&action=demandeValidation&mail=$lelogin\"</script>" ;
    // header('Location: index.php?uc=validation&action=demandeValidation&mail='.$lelogin.'');
    

  

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
            echo "<script> alert('Merci ! Veuillez désormais attendre la validation du compte par un Validateur.'); window.location.href=\"index.php\"; </script>";
        }
        else{
            echo "<script> alert('Erreur dans la requête') </script>";
        }
        
    }
    

}

function tokenCo($token,$login):bool
{
    $dt = new DateTime();
    $dt->modify('+5 minutes');
    $dt = $dt->format('Y-m-d h:i:s');
    
    
    
    $pdoStatement = PdoGsb::$monPdo->prepare("UPDATE medecin SET token = :token , dateTokenExp = :ladate WHERE mail=:mail");
    $bv1 = $pdoStatement->bindValue(':mail', $login);
    $bv9 = $pdoStatement->bindValue(':token', $token);
    $bv9 = $pdoStatement->bindValue(':ladate', $dt);

    $execution = $pdoStatement->execute();
    return $execution;

}

function valideCode($token,$login):bool
{
    $pdo = PdoGsb::$monPdo;
    $verifToken=PdoGsb::$monPdo->prepare("SELECT * FROM medecin WHERE token= :token && mail=:mail");
    $bvc1=$verifToken->bindValue(':token',$token,PDO::PARAM_STR);
    $bvc2=$verifToken->bindValue(':mail',$login,PDO::PARAM_STR);
    $verifToken->execute();
    $rep=$verifToken->fetch();
    
    
    $mtn=new DateTime();$mtn=$mtn->format('Y-m-d h:i:s'); //La date actuelle
    $dateToken=new DateTime($rep['dateTokenExp']);$dateToken=$dateToken->format('Y-m-d h:i:s'); //La date à laquelle le token a été créé

    if ($rep['token']!=$token){
        echo "<script> alert('Le token est incorrect ! Veuillez réessayer'); </script>";
        return false;
    }

    if ($mtn>$dateToken){
        echo "<script> alert('Le token a expiré !'); window.location.href=\"index.php\"; </script>";
        return false;
    }

    
    if (($rep['token']==$token)&&($mtn<$dateToken)){
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
    
    
    // if (($jourToken!=0) || empty($rep['token'])){ //Si l'écart est différent de 0 (donc si le token a + de 24h d'existence)
    //   echo "<script> alert('Votre token n\'est plus valide ! Veuillez contacter un administrateur.'); window.location.href=\"index.php\"; </script>";
    //   return false;
    // } 

    else return false;
}

?>