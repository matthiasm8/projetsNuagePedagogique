<?php
if (!$_SESSION['id'])
    header('Location: ../index.php');
else {
?>
﻿<!DOCTYPE html>
<head>
    <title>Accueil - GSB extranet</title>
  </head>
  <body background="assets/img/laboratoire.jpg">

    <div class="container">
    <div class="row">
        <h2> Bonjour <?php echo $_SESSION['prenom'].' '.$_SESSION['nom'].' !';?></h2><br>
        <div class="col-4">
            <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=produits&action=listeproduits';"> Gestion des Produits</button>
        </div><br>
        <div class="col-4">
            <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=cdp&action=ajoutproduit';"> Ajouter un produit</button>
        </div><br>
        <div class="col-4">
            <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=visios&action=listevisios';"> Liste des visioconférences</button>
        </div><br>
        <div class="col-4">
            <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href='index.php?uc=cdp&action=ajoutvisio';"> Créer une visioconférence</button>
        </div><br>
    </div>
</div>
<?php };?>

