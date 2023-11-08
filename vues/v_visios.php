<?php
if (!$_SESSION['id'])
    header('Location: ../index.php');
else 
?>
﻿<!DOCTYPE html>
   <head>
    <title>Liste des Visios - GSB extranet</title>
  </head>
  <body background="assets/img/laboratoire.jpg">

  <?php
         $pdo = PdoGsb::$monPdo;
         $sql=$pdo->prepare("SELECT * FROM visioconference WHERE dateVisio > now()");
         $sql->execute();

         $reqmed=$pdo->prepare("SELECT m.nom,m.prenom,dateavis,avismedecin,v.nomVisio FROM medecinvisio INNER JOIN visioconference v ON medecinvisio.idVisio=v.id INNER JOIN medecin m ON m.id=medecinvisio.idMedecin WHERE valideavis=1;
         ");
         $reqmed->execute();
         
         $sql2=$pdo->prepare("SELECT * FROM visioconference WHERE dateVisio < now()");
         $sql2->execute();
     
        ?>
<h3> Toutes les visioconférences à venir </h3>
<?php                    while($row = $sql->fetch(PDO::FETCH_ASSOC)) :
                         $nom=$row['nomVisio'];
                         $objectif=$row['objectif'];
                         $url=$row['url'];
                         $date=$row['dateVisio'];
                         $id=$row['id'];
                         ?>
  <div class="col-sm-2">                        
    <div class="card bg-transparent" >
    <iframe height="200" src="<?php echo $url;?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

      <div class="card-body bg-primary">
        <h5 class="card-title fw-bold"><?php echo $nom;?></h5>
        <p class="card-text"><?php echo $objectif;?></p>
      </div>
      <div class="card-body bg-primary">
      <h5 class="card-title fw-bold">Prévue pour le <?php echo $date;?></h5>
        
      </div>
      <?php if($_SESSION['role']==5){
        $sqle=$pdo->prepare("SELECT * FROM medecinvisio WHERE idVisio=:idV && idMedecin=:idM");
        $bv1 = $sqle->bindValue(':idM', $_SESSION['id']);
        $bv1 = $sqle->bindValue(':idV', $id);
        $sqle->execute();
        $a=$sqle->rowCount();

        if ($a==0){
        ?>
        <div class="card-body bg-secondary">
          <a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=medecin&action=inscrirevisio&id=<?php echo $id ?>" class="card-link" style="color:#0000FF;">S'inscrire</a>
        </div>
      <?php }
    else echo '<div class="card-body bg-secondary">
    <a class="card-link" style="color:#0000FF;">Déjà Inscrit !</a>
  </div>';
    
    }?>
      <?php if($_SESSION['role']==2){?>
        <div class="card-body bg-secondary">
          <a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=cdp&action=modifievisio&id=<?php echo $id ?>" class="card-link" style="color:#0000FF;">Modifier</a>
          <a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=cdp&action=supprimevisio&id=<?php echo $id ?>" class="card-link" style="color:red;" onclick="return confirm('Voulez vous vraiment supprimer cette visioconférence ?');">Supprimer</a>
        </div>
      <?php }?>
    </div>
  </div>
<?php endwhile;?>




	
	<div class="page-content">


    <div class="headings d-flex justify-content-between align-items-center mb-3">
        <h3>Avis sur les visios passées</h3>
        
    </div>

    <div class="col-sm-4"> <?php                    while($lesavis = $reqmed->fetch(PDO::FETCH_ASSOC)) :
                         $text=$lesavis['avismedecin'];
                         $lemed=$lesavis['prenom'].' '.$lesavis['nom'];
                         $dateavis=$lesavis['dateavis'];
                         $lavisio=$lesavis['nomVisio'];
                         ?>

    <div class="card ">

        <div class="d-flex justify-content-between align-items-center">

      <div class="user d-flex flex-row align-items-center">

        <img src="./assets/img/medecin.png" width="50" class="user-img rounded-circle mr-2">
        <span class="font-weight-bold text-primary"><?php echo $lemed;?></span><span class="font-weight-bold">"<?php echo $text;?>"<br>Concernant la visio : <?php echo $lavisio;?></span><br>
        
          
      </div>


      <small><?php echo $dateavis;?></small>

      </div>
        
    </div><br><br><?php endwhile;?>
      </div>
    </div>

<h3> Toutes les visioconférences passées </h3>
<?php                    while($row = $sql2->fetch(PDO::FETCH_ASSOC)) :
                         $nom=$row['nomVisio'];
                         $objectif=$row['objectif'];
                         $url=$row['url'];
                         $date=$row['dateVisio'];
                         $id=$row['id'];
                         ?>
  <div class="col-sm-2">                        
    <div class="card bg-transparent" >
    <iframe height="200" src="<?php echo $url;?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

      <div class="card-body bg-primary">
        <h5 class="card-title fw-bold"><?php echo $nom;?></h5>
        <p class="card-text"><?php echo $objectif;?></p>
      </div>
      <div class="card-body bg-primary">
      <h5 class="card-title fw-bold">A eu lieu le <?php echo $date;?></h5>
        
      </div>
      <?php if($_SESSION['role']==5){
        $sqle=$pdo->prepare("SELECT * FROM medecinvisio WHERE idVisio=:idV && idMedecin=:idM");
        $bv1 = $sqle->bindValue(':idM', $_SESSION['id']);
        $bv1 = $sqle->bindValue(':idV', $id);
        $sqle->execute();
        $a=$sqle->rowCount();

        if ($a==1){
        ?>
        <div class="card-body bg-secondary">
          <p class="card-text">Vous avez assisté à cette visio</p>
        </div>
      <?php }   
    }?>
      <?php if($_SESSION['role']==2){?>
        <div class="card-body bg-secondary">
          <a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=cdp&action=modifievisio&id=<?php echo $id ?>" class="card-link" style="color:#0000FF;">Modifier</a>
          <a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=cdp&action=supprimevisio&id=<?php echo $id ?>" class="card-link" style="color:red;" onclick="return confirm('Voulez vous vraiment supprimer cette visioconférence ?');">Supprimer</a>
        </div>
      <?php }?>
    </div><br><br><br><br>
  </div>
<?php endwhile;?>
<?php ;?>
