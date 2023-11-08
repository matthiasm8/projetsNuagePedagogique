<?php
if (!$_SESSION['id'])
    header('Location: ../index.php');
else {
?>
﻿<!DOCTYPE html>
<html lang="fr">
   <head>
    <title>Accueil - GSB extranet</title>
  </head>
  <body background="assets/img/laboratoire.jpg">
    <div class="container">
    <div class="row">
        <h2> Bonjour <?php echo $_SESSION['prenom'].' '.$_SESSION['nom'].' !';?></h2><br>
        <div class="col-4">
            <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=medecin&action=mesvisio';"> Mes visioconférences</button>
        </div><br>
        <div class="col-4">
            <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=produits&action=listeproduits';"> Liste des Produits</button>
        </div><br>
        <div class="col-4">
            <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=visios&action=listevisios';"> Liste des Visios</button>
        </div><br>
        <!-- <div class="col-4">
            <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=medecin&action=inscrirevisio';"> M'inscrire à une visio</button>
        </div> -->
    </div>
</div>

<?php };?>

