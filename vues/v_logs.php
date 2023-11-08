<?php
if (!$_SESSION['id'])
    header('Location: ../index.php');
else 
?>
﻿<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Historique des modifications - GSB extranet</title>
  </head>
  <body background="assets/img/laboratoire.jpg">

  <?php
         $pdo = PdoGsb::$monPdo;
         $sql=$pdo->prepare("SELECT * FROM logsproduit");
         $sql->execute();

         $pdo = PdoGsb::$monPdo;
         $sql2=$pdo->prepare("SELECT * FROM logsvisio");
         $sql2->execute();
         
     
        ?>

<div class="container">
  <h3>Modification / Suppression de Produits</h3>
  <div class="table-secondary">
    <table class="table">
      <thead>
        <tr class="bg-primary">
          <th scope="col">Produit concerné</th>
          <th scope="col">Modifié par</th>
          <th scope="col">Le</th>
          <th scope="col">Modifications apportées</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $sql->fetch(PDO::FETCH_ASSOC)) : ?>
          <tr>
            <td><?php echo $row['libelleproduit'] ?></td>
            <td><?php echo $row['lecdp'] ?></td>
            <td><?php echo $row['date'] ?></td>
            <td><?php echo $row['typemodif'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="container">
  <h3>Modification / Suppression de Visios</h3>
  <table id="myTable" class="table table-hover">
    <caption><center></center></caption>
    <thead>
      <tr id="tr" class="tr bg-success text-white">
        <th scope="col">Visio concernée</th>
        <th scope="col">Modifié par</th>
        <th scope="col">Le</th>
        <th scope="col">Modifications apportées</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($vis = $sql2->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr>
          <td><?php echo $vis['nomvisio'] ?></td>
          <td><?php echo $vis['lecdp'] ?></td>
          <td><?php echo $vis['date'] ?></td>
          <td><?php echo $vis['typemodif'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>




	
	<div class="page-content">
    	<div class="row">

<?php ;?>
