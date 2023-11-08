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

<?php
if (!$_SESSION['id']) {
    header('Location: ../index.php');
} else {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Mes visioconférences - GSB extranet</title>
    <!-- Inclure les fichiers CSS de Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body background="assets/img/laboratoire.jpg">

<div class="container-large">    
    <div class="row justify-content-left">
            <div class="col-md-3"><h3>Mes visios à venir</h3>
            <?php while ($row = $sql->fetch(PDO::FETCH_ASSOC)) : 
                        $nom=$row['nomVisio'];
                         $objectif=$row['objectif'];
                         $url=$row['url'];
                         $date=$row['dateVisio'];
            ?>  <br>
                <div class="card bg-transparent" >
                    <iframe height="200" src="<?php echo $url;?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

                    <div class="card-body bg-primary">
                        <h5 class="card-title fw-bold"><?php echo $nom;?></h5>
                        <p class="card-text"><?php echo $objectif;?></p>
                    </div>
                    <div class="card-body bg-primary">
                        <h5 class="card-title fw-bold">Prévue pour le <?php echo $date;?></h5>
                    </div>
                </div><?php endwhile; ?><br><br><br>
            </div>


    
    
            <div class="col-md-3"><h3>Mes visios passées</h3>
            <?php while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) : 
            $nom=$row['nomVisio'];
            $objectif=$row['objectif'];
            $url=$row['url'];
            $date=$row['dateVisio'];
            $avis=$row['avismedecin'];
            $id=$row['id'];
        ?>      <br>
                <div class="card bg-transparent" >
                    <iframe height="200" src="<?php echo $url;?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

                <div class="card-body bg-primary">
                    <h5 class="card-title fw-bold"><?php echo $nom;?></h5>
                    <p class="card-text"><?php echo $objectif;?></p>
                </div>
                <div class="card-body bg-primary">
                  <h5 class="card-title fw-bold">S'est déroulée le <?php echo $date;?></h5>
                    <h5 class="card-title fw-bold"><?php if (!empty($avis)){echo 'Votre avis : '.$avis;}else echo '<form action="index.php?uc=medecin&action=donneavis&id='.$id.'" method="post" enctype="multipart/form-data" id="form">
                                    <input type="text" name="avis" placeholder="Votre commentaire.." required ></input>
                                    <button type="submit">Poster un avis</button>
                            </form>';?></h5>
                    
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
<?php
}
?>
