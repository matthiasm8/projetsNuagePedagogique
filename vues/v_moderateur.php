<!DOCTYPE html>
<?php 
    $pdo = PdoGsb::$monPdo;
    $sql=$pdo->prepare("SELECT m.nom,m.prenom,v.nomVisio,dateavis,avismedecin,idMedecin,idVisio FROM medecinvisio INNER JOIN medecin m ON m.id=medecinvisio.idMedecin INNER JOIN visioconference v ON v.id=medecinvisio.idVisio WHERE avismedecin IS NOT NULL && valideavis =0;
    ");
    $sql->execute();
    $nbavis=$sql->rowCount();
?>
<html lang="fr">
<head>
    <title>GSB - extranet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body background="assets/img/laboratoire.jpg">

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <div class="container text-center">
      <h3> Vous avez <?php echo $nbavis?> avis à valider</h3>

      <table id="myTable" class="table table-striped table-dark">
                   <thead> <!-- En-tête du tableau -->
                       <tr id="tr" class="tr bg-success text-white" >
                           <th scope="col" >Ecrit par</th>
                           <th scope="col" >Concernant la visio</th>
                           <th scope="col" >Avis</th>
                           <th onclick="sortTable(3)" scope="col" >Date de l'avis</th>
                           <th onclick="sortTable(5)" scope="col">Valider</th>
                        </tr>
                   </thead>
                   <tbody> 
                   <?php 
                   while($row = $sql->fetch(PDO::FETCH_ASSOC)) :
                         $auteur=$row['prenom'].' '.$row['nom'];
                         $avis=$row['avismedecin'];
                         $lavisio=$row['nomVisio'];
                         $date=$row['dateavis'];
                         $idV=$row['idVisio'];
                         $idM=$row['idMedecin'];
                   ?>
                    <!-- Corps du tableau -->
                       <tr>
                           <td><?php echo $auteur ?></td>
                           <td><?php echo $lavisio?></td>                          
                           <td><?php echo $avis?></td>
                           <td><?php echo $date ?></td>
                           <td><form action="index.php?uc=moderateur&action=valideavis&idM=<?php echo $idM ?>&idV=<?php echo $idV ?>" method="post" id="form">
                                <button type="submit">Valider l'avis</button>
                              </form>
                           </td>
                           
                       </tr>
                       <?php endwhile;?>
                   </tbody>
          </table>

                   </div>
  </body>
</html>