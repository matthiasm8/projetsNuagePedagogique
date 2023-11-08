<?php
if (!$_SESSION['id'])
    header('Location: ../index.php');
else 
?>
﻿<!DOCTYPE html>
<html lang="fr">
<head>
     <title>Mes visioconférences - GSB extranet</title>
  </head>
  <body background="assets/img/laboratoire.jpg">


    <?php
         $pdo = PdoGsb::$monPdo;
         $sql=$pdo->prepare("SELECT v.dateVisio,v.nomVisio,v.objectif,v.url,avismedecin,dateInscription,v.id FROM `medecinvisio` INNER JOIN visioconference v ON medecinvisio.idVisio=v.id WHERE v.dateVisio > now() && idMedecin=:id;");
         $bv1 = $sql->bindValue(':id', $_SESSION['id']);
         $sql->execute();
         
         $sql2=$pdo->prepare("SELECT v.dateVisio,v.nomVisio,v.objectif,v.url,avismedecin,dateInscription,v.id FROM `medecinvisio` INNER JOIN visioconference v ON medecinvisio.idVisio=v.id WHERE v.dateVisio <  now() && idMedecin=:id;");
         $bv = $sql2->bindValue(':id', $_SESSION['id']);
         $sql2->execute();

        ?>
<div class="container-large">
<h3> Mes visios à venir </h3>
<?php                    while($row = $sql->fetch(PDO::FETCH_ASSOC)) :
                         $nom=$row['nomVisio'];
                         $objectif=$row['objectif'];
                         $url=$row['url'];
                         $date=$row['dateVisio'];
                         ?>
  <div class="row justify-content-left">
      <div class="col-2">                       
        <div class="card bg-transparent" >
        <iframe height="200" src="<?php echo $url;?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

          <div class="card-body bg-primary">
            <h5 class="card-title fw-bold"><?php echo $nom;?></h5>
            <p class="card-text"><?php echo $objectif;?></p>
          </div>
          <div class="card-body bg-primary">
            <p class="card-text">Date : <br><?php echo $date;?></p>
          </div>
        </div>
      

<?php endwhile;?>




<h3> Mes visios passées </h3>
<?php                    while($row = $sql2->fetch(PDO::FETCH_ASSOC)) :
                         $nom=$row['nomVisio'];
                         $objectif=$row['objectif'];
                         $url=$row['url'];
                         $date=$row['dateVisio'];
                         $avis=$row['avismedecin'];
                         $id=$row['id'];
                         ?>
   <div class="row justify-content-center">    
  <div class="col-2">                           
    <div class="card bg-transparent" >
    <iframe height="200" src="<?php echo $url;?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

      <div class="card-body bg-primary">
        <h5 class="card-title fw-bold"><?php echo $nom;?></h5>
        <p class="card-text"><?php echo $objectif;?></p>
      </div>
      <div class="card-body bg-primary">
        <p class="card-text">Date : <br><?php echo $date;?></p>
        <p class="card-text">Mon avis :<?php if (!empty($avis)){echo $avis;}else echo 'Pas encore d\'avis!';?></p>
        <form action="index.php?uc=medecin&action=donneavis&id=<?php echo $id;?>" method="post" enctype="multipart/form-data" id="form">
                    <br>
                        <h5 class="card-title text-light">Poster un avis</h5>
                        <textarea id="MyID" name="avis" placeholder="Votre commentaire.."></textarea>
                        <p><button type="submit">Poster mon commentaire</button>
                </form>
      </div>
    </div>
  </div>
<?php endwhile;?>
</div>



<?php ;?>

