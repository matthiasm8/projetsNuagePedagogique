<?php

/** 
 * Classe d'accÃ¨s aux donnÃ©es. 
 
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
      	private static $mdp='cZrKfsFFyAhfchB' ;	
	private static $monPdo;
	private static $monPdoGsb=null; 
		
/**
 * Constructeur privÃ©, crÃ©e l'instance de PDO qui sera sollicitÃ©e
 * pour toutes les mÃ©thodes de la classe
 */				
	private function __construct(){
          
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crÃ©e l'unique instance de la classe
 
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
 * vÃ©rifie si le login et le mot de passe sont corrects
 * renvoie true si les 2 sont corrects
 * @param type $lePDO
 * @param type $login
 * @param type $pwd
 * @return bool
 * @throws Exception
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
           if ($pwd==$unUser['motDePasse'])
                $user=true;
        }
    }
    else
        throw new Exception("erreur dans la requÃªte");
return $user;   
}

/**
 * Fonction de recherche d'un médecin par son adresse e-mail
 * Elle intéragit avecune base de données via PDO
 * Elle prépare une requête en SQL pour sélectionner un médecin par son adresse e-mail, exécute la requête
 * avec la valeur donnée en paramètre et retourne le résultat
 * 
 * @param string login L'adresse e-mail du médecin à rechercher
 * @return array false Retourne un tableau associatif contentant les données du médecin trouvé,
 * ou false si aucune correspondance n'est trouvée
 * @throws Expeption
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

/**
 * Obtient la taille maximale du champ 'mail' dans la table 'medecin' de la base de données.
 *
 * Cette fonction interagit avec une base de données via l'objet PDO.
 * Elle prépare une requête SQL pour récupérer la taille maximale du champ 'mail' dans la table 'medecin',
 * exécute la requête, puis retourne la valeur de la taille.
 *
 * @return int|false Retourne la taille maximale du champ 'mail' dans la table 'medecin',
 *ou false si une erreur survient lors de l'exécution de la requête SQL.
 */
public function tailleChampsMail(){
   
     $pdoStatement = PdoGsb::$monPdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = 'medecin' AND COLUMN_NAME = 'mail'");
    $execution = $pdoStatement->execute();
$leResultat = $pdoStatement->fetch();
      
      return $leResultat[0];
    
       /*Classe qui sert à vérifier la taille maximal que peut prendre une adresse e-mail
       Cela est fait pour limiter les possibles attaques par injection*/ 
       
}

/**
 * Crée un nouveau médecin dans la base de données.
 *
 * Cette fonction interagit avec une base de données via l'objet PDO.
 * Elle prépare une requête SQL pour insérer un nouveau médecin avec son adresse e-mail et mot de passe,
 * exécute la requête en utilisant les valeurs fournies en paramètres, puis retourne le résultat de l'exécution.
 *
 * @param string $email L'adresse e-mail du médecin à créer.
 * @param string $mdp Le mot de passe du médecin à créer (doit être déjà haché).
 *
 * @return bool Retourne true si l'insertion a réussi, sinon false.
 */
public function creeMedecin($email, $mdp)
{
   
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecin(id,mail, motDePasse,dateCreation,dateConsentement) "
            . "VALUES (null, :leMail, :leMdp, now(),now())");
    $bv1 = $pdoStatement->bindValue(':leMail', $email);
    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $bv2 = $pdoStatement->bindValue(':leMdp', $mdp);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

/**
 * Vérifie si une adresse e-mail existe déjà dans la base de données des médecins.
 *
 * Cette fonction interagit avec une base de données via l'objet PDO.
 * Elle prépare une requête SQL pour compter le nombre d'occurrences d'une adresse e-mail donnée dans la table 'medecin',
 * exécute la requête avec l'adresse e-mail fournie en paramètre, puis retourne true si l'adresse e-mail existe,
 * sinon retourne false.
 *
 * @param string $email L'adresse e-mail à vérifier.
 *
 * @return bool Retourne true si l'adresse e-mail existe déjà dans la base de données, sinon false.
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

/**
 * Effectue la connexion initiale d'un médecin en enregistrant cette action dans la base de données.
 *
 * Cette fonction interagit avec une base de données via l'objet PDO et d'autres méthodes de la classe
 * à laquelle elle appartient (supposée être une classe personnalisée).
 * Elle récupère le médecin correspondant à l'adresse e-mail donnée, obtient son identifiant,
 * puis enregistre cette connexion initiale dans la base de données en utilisant la méthode 'ajouteConnexionInitiale'.
 *
 * @param string $mail L'adresse e-mail du médecin pour laquelle la connexion initiale est effectuée.
 */

function connexionInitiale($mail){
     $pdo = PdoGsb::$monPdo;
    $medecin= $this->donneLeMedecinByMail($mail);
    $id = $medecin['id'];
    $this->ajouteConnexionInitiale($id);
    
}

/**
 * Effectue la connexion initiale d'un médecin en enregistrant cette action dans la base de données.
 *
 * Cette fonction interagit avec une base de données via l'objet PDO et d'autres méthodes de la classe
 * à laquelle elle appartient (supposée être une classe personnalisée).
 * Elle récupère le médecin correspondant à l'adresse e-mail donnée, obtient son identifiant,
 * puis enregistre cette connexion initiale dans la base de données en utilisant la méthode 'ajouteConnexionInitiale'.
 *
 * @param string $mail L'adresse e-mail du médecin pour laquelle la connexion initiale est effectuée.
 */

function ajouteConnexionInitiale($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO historiqueconnexion "
            . "VALUES (:leMedecin, now(), now())");
    $bv1 = $pdoStatement->bindValue(':leMedecin', $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

/**
 * Récupère les informations d'un médecin à partir de son identifiant.
 *
 * Cette fonction interagit avec une base de données via l'objet PDO.
 * Elle prépare une requête SQL pour sélectionner un médecin par son identifiant,
 * exécute la requête avec l'identifiant fourni en paramètre, puis retourne les informations du médecin sous forme d'un tableau associatif.
 *
 * @param int $id L'identifiant du médecin dont les informations sont recherchées.
 *
 * @return array|false Retourne un tableau associatif contenant les informations du médecin
 *                    (id, nom, prénom), ou false si aucune correspondance n'est trouvée.
 *
 * @throws Exception Si une erreur survient lors de l'exécution de la requête SQL.
 */

function donneinfosmedecin($id){
  
       $pdo = PdoGsb::$monPdo;
           $monObjPdoStatement=$pdo->prepare("SELECT id,nom,prenom FROM medecin WHERE id= :lId");
    $bvc1=$monObjPdoStatement->bindValue(':lId',$id,PDO::PARAM_INT);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
   
    }
    else
        throw new Exception("erreur");
           
    /*Les lignes ci-dessus servent à donner les informations sur les médecins*/
}
}
?>