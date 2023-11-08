<?php
if (!$_SESSION['id'])
    header('Location: ../index.php');
else 
?>
﻿<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Liste des Produits - GSB extranet</title>
  </head>
  <body background="assets/img/laboratoire.jpg">

  <?php
         $pdo = PdoGsb::$monPdo;
        //  $sql=$pdo->prepare("SELECT libelleproduit,lg.date ,image, m.nom,m.prenom FROM `medecinproduit` INNER JOIN medecin m ON medecinproduit.idMedecin=m.id INNER JOIN produit p ON medecinproduit.idProduit=p.id INNER JOIN logsproduit lg ON p.nom=lg.libelleproduit;         ");
         $sql=$pdo->prepare("SELECT nom,lg.date ,produit.id,image FROM `produit` INNER JOIN logsproduit lg ON nom=lg.libelleproduit WHERE lg.typemodif='Création'");
         $sql->execute();
     
        ?>
<div class="row">
<h3> Produits disponibles </h3>
<?php while($row = $sql->fetch(PDO::FETCH_ASSOC)) :
                         $produit=$row['nom'];
                         $dateajout=$row['date'];
                         $img=$row['image'];
                         $id=$row['id'];

                         $sql2=$pdo->prepare("SELECT m.nom,m.prenom FROM `medecinproduit` INNER JOIN medecin m ON medecinproduit.idMedecin=m.id WHERE idProduit=:id && action='Aimer'");
                         $bv1 = $sql2->bindValue(':id', $id);
                         $sql2->execute();
                         $nbaime=$sql2->rowCount();

                         $sqli=$pdo->prepare("SELECT idProduit FROM `medecinproduit` WHERE idProduit=:id && action='Consultation'");
                         $bv1 = $sqli->bindValue(':id', $id);
                         $sqli->execute();
                         $nbvues=$sqli->rowCount();
                         
?> 
  <div class="col-sm-2">             
          
    <div class="card bg-transparent" >
      <?php if (!empty($row['image'])){?><img src="./images_produits/<?php echo $img?>"  class="card-img-top" height="200px"><?php } else {?> <img src="./images_produits/default.png"  class="card-img-top" height="200px"> <?php }?></td>

      <div class="card-body bg-primary">
        <h5 class="card-title fw-bold"><?php echo $produit;?></h5>
        <h5 class="card-title fw-bold">Ajouté à la liste le <?php echo $dateajout;?></h5>

      <div class="card-body bg-primary">
      <h5 class="card-title fw-bold">A été consulté <?php echo $nbvues; ?> fois</h5>
      <h5 class="card-title fw-bold">A été aimé <?php echo $nbaime; ?> fois</h5>
        <?php if ($nbaime!=0){?><h5 class="card-title fw-bold">Médecin ayant aimé : </h5><p class="card-text"><?php while($row = $sql2->fetch(PDO::FETCH_ASSOC)) : echo $row['prenom'].' '.$row['nom'].'<br>'; endwhile;}?></p>
      </div>

      <?php if($_SESSION['role']==2){?>
        <div class="card-body bg-secondary">
          <a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=cdp&action=modifieproduit&id=<?php echo $id ?>" class="card-link" style="color:#0000FF;">Modifier</a>
          <a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=cdp&action=supprimeproduit&id=<?php echo $id ?>" class="card-link" style="color:red;" onclick="return confirm('Voulez vous vraiment supprimer ce produit ?');">Supprimer</a>
        </div>
      <?php }?>
    </div>
  </div>
      </div>
<?php endwhile;?>
</div>





	
	<div class="page-content">
    	<div class="row">

<?php ;?>
