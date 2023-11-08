<?php
if (!$_SESSION['id'])
    header('Location: ../index.php');
else {
?>
﻿<!DOCTYPE html>
<head>
    <title>Accueil ADMIN - GSB extranet</title>
  </head>
  <body background="assets/img/laboratoire.jpg">

    <div class="container">
    <div class="row">
        <h2> Bonjour <?php echo $_SESSION['prenom'].' '.$_SESSION['nom'].' !';?></h2><br>
        <div class="col-4">
            <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=admin&action=planmaintenance';">Planifier une maintenance</button>
            <br></div>
        <div class="col-4">
            <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=admin&action=logs';"> Historique de modifications</button>
            <br></div>
        <div class="col-4">
            <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=produits&action=listeproduits';"> Liste des produits</button>
            <br> </div>
        <div class="col-4">
            <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=visios&action=listevisios';"> Liste des visioconférences</button>
            <br> </div>
        <div class="col-4">
        <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=admin&action=statsproduits';"> Statistiques Produits</button>
        </div><br>
    </div>
</div>
<?php };?>

