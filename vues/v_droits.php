<!DOCTYPE html>
<html lang="fr">
<?php require_once ("vues/v_sommaire.php");?>
<head>
    <title>Mes données - GSB extranet</title>
</head>

  <body background="assets/img/laboratoire.jpg">

<div class="page-content container">
  <h2>Droit de portabilité :</h2>
  <h4>Vous pouvez télécharger vos données en cliquant <a href="portabilite/<?php echo $_SESSION['id']?>.json" download>ici</a><br><br>
  <h2>Droit à l'oubli :</h2> 
      <h4>Je souhaite désactiver mon compte (ce compte sera irrécupérable !) :
        <br><a onclick="return confirm('Voulez vous vraiment supprimer votre compte ? \n Cette action est irréversible !');" href="index.php?uc=droits&action=supprimer" >Supprimer mon compte ainsi que toutes mes données</a>
        <br><a onclick="return confirm('Voulez vous vraiment supprimer votre compte ? \n Cette action est irréversible !');" href="index.php?uc=droits&action=archiver" >Supprimer mon compte et autoriser GSB à archiver mes données à des fins statistiques</a>
  </h4>
</div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>