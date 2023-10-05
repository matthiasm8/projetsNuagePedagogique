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

function checkUser($login,$pwd):bool {
    //AJOUTER TEST SUR TOKEN POUR ACTIVATION DU COMPTE
    $user=false;
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT motDePasse FROM medecin WHERE mail= :login AND token IS NULL");
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

public function creeMedecin($email, $mdp,$token)
{
   
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecin(id,mail, motDePasse,dateCreation,dateConsentement,token) "
            . "VALUES (null, :leMail, :leMdp, now(),now(),:leToken)");
    $bv1 = $pdoStatement->bindValue(':leMail', $email);
   
    $bv2 = $pdoStatement->bindValue(':leMdp', $mdp);
    $bv2 = $pdoStatement->bindValue(':leToken', $token);
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
            . "VALUES (:leMedecin, now(), now())");
    $bv1 = $pdoStatement->bindValue(':leMedecin', $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

/*
 * Fonction qui donne des informations sur un médecin en fonction de l'id reçu en paramètre
*/

function donneinfosmedecin($id){
  
       $pdo = PdoGsb::$monPdo;
           $monObjPdoStatement=$pdo->prepare("SELECT id,nom,prenom FROM medecin WHERE id= :lId");
    $bvc1=$monObjPdoStatement->bindValue(':lId',$id,PDO::PARAM_INT);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
        var_dump($unUser);
    }
    else
        throw new Exception("erreur");
           
    
}

function creefichierjson($id){
  
    $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement=$pdo->prepare("SELECT id,nom,prenom,telephone,mail,dateNaissance,dateCreation,rpps,dateDiplome,dateConsentement FROM medecin WHERE id= :lId");
 $bvc1=$monObjPdoStatement->bindValue(':lId',$id,PDO::PARAM_INT);
 if ($monObjPdoStatement->execute()) {
     $unUser=$monObjPdoStatement->fetch();
     var_dump($unUser);
     
 }
 else
     throw new Exception("erreur");
}

/* Fonction qui envoie un token de vérification de 6 caractères à l'adresse mail indiquée. */

function envoiMail($token){
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
    /*$mail->Body = file_get_contents("templatemail.php");*/
    $mail->Body = '<!doctype html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Simple Transactional Email</title><style>@media only screen and (max-width: 620px) { table.body h1 { font-size: 28px !important; margin-bottom: 10px !important; } table.body p, table.body ul, table.body ol, table.body td, table.body span, table.body a { font-size: 16px !important; } table.body .wrapper, table.body .article { padding: 10px !important; } table.body .content { padding: 0 !important; } table.body .container { padding: 0 !important; width: 100% !important; } table.body .main { border-left-width: 0 !important; border-radius: 0 !important; border-right-width: 0 !important; } table.body .btn table { width: 100% !important; } table.body .btn a { width: 100% !important; } table.body .img-responsive { height: auto !important; max-width: 100% !important; width: auto !important; } } @media all { .ExternalClass { width: 100%; } .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; } .apple-link a { color: inherit !important; font-family: inherit !important; font-size: inherit !important; font-weight: inherit !important; line-height: inherit !important; text-decoration: none !important; } #MessageViewBody a { color: inherit; text-decoration: none; font-size: inherit; font-family: inherit; font-weight: inherit; line-height: inherit; } .btn-primary table td:hover { background-color: #34495e !important; } .btn-primary a:hover { background-color: #34495e !important; border-color: #34495e !important; } }</style></head><body style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"><span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span><table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" width="100%" bgcolor="#f6f6f6"><tr><td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td><td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;" width="580" valign="top"><div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;"><table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;" width="100%"><tr><td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top"><table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%"><tr><td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top"><p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Bonjour,</p><p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Voici votre code de validation pour accèder à GSB Extranet.</p><table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; width: 100%;" width="100%"><tbody><tr><td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;" valign="top"><table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;"><tbody><tr><td style="font-family: sans-serif; font-size: 14px; vertical-align: top; border-radius: 5px; text-align: center; background-color: #3498db;" valign="top" align="center" bgcolor="#3498db"> <a  style="border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; background-color: #3498db; border-color: #3498db; color: #ffffff;">'.$token.'</a> </td></tr></tbody></table></td></tr></tbody></table><p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Ce code à usage unique est valable pour 24 heures.</p><p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Cliquez <a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/vues/v_validation.php" target="_blank">ici</a> pour valider votre compte.</p></td></tr></table></td></tr><!-- END MAIN CONTENT AREA --></table><!-- END CENTERED WHITE CONTAINER --><!-- START FOOTER --><div class="footer" style="clear: both; margin-top: 10px; text-align: center; width: 100%;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%"><tr><td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;" valign="top" align="center"><span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">Balavoine Dev, 59 rue Jose Fonte, Lille 59000</span><br> Don\'t like these emails? <a href="http://i.imgur.com/CScmqnj.gif" style="text-decoration: underline; color: #999999; font-size: 12px; text-align: center;">Unsubscribe</a>.</td></tr><tr><td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;" valign="top" align="center">Powered by <a href="http://htmlemail.io" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;">HTMLemail</a>.</td></tr></table></div><!-- END FOOTER --></div></td><td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td></tr></table></body></html>';

    $mail->send();

    header('Location: vues/v_validation.php');
    

}

}

/* Fonction qui vérifie si le token entré par l'utlisateur correspond à celui envoyé sur son adresse mail. */

function valideUser($token){

    $verifToken=PdoGsb::$monPdo->prepare("SELECT token FROM medecin WHERE token= :token");
    $bvc1=$verifToken->bindValue(':token',$token,PDO::PARAM_STR);
    $verifToken->execute();
    $rep=$verifToken->fetch();
    
    $tokenBase=$rep['token'];

    if ($tokenBase==$token){
        $validationCompte=PdoGsb::$monPdo->prepare("UPDATE `medecin` SET `token`=NULL,`valide`=1 WHERE token=:token");
        $bvc1=$validationCompte->bindValue(':token',$token,PDO::PARAM_STR);
        if($validationCompte->execute()){
            echo "<script> alert('Votre compte a bien été validé ! Vous pouvez vous connecter'); window.location.href=\"index.php\"; </script>";
        }
        else{
            echo "<script> alert('Erreur dans la requête') </script>";
        }
        
    }
    else{
        echo "<script> alert('Token incorrect'".$token.") </script>";
    }
    

}

?>