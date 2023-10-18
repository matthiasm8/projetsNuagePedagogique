<!DOCTYPE html>
<?php 
    $pdo = PdoGsb::$monPdo;
    $sql=$pdo->prepare("SELECT * FROM `medecin` WHERE valide=1 ");
    $sql->execute();
    $nbMed=$sql->rowCount();
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
      
      <table id="myTable" class="table table-hover">
                   <caption><center>Vous avez <?php echo $nbMed?> utilisateurs à valider</center></caption>
                   <thead> <!-- En-tête du tableau -->
                       <tr id="tr" class="tr bg-success text-white" >
                           <th onclick="sortTable(1)" scope="col" >Nom</th>
                           <th onclick="sortTable(2)" scope="col" >Prénom</th>
                           <th onclick="sortTable(3)" scope="col" >Date création compte</th>
                           <th onclick="sortTable(1)" scope="col" >Mail</th>
                           <th onclick="sortTable(2)" scope="col" >N° Téléphone</th>                           
                           <th onclick="sortTable(4)" scope="col">RPPS</th>
                           <th onclick="sortTable(5)" scope="col">Date diplôme</th>
                           <th onclick="sortTable(5)" scope="col">Accepter / Refuser</th>
                        </tr>
                   </thead>
                   <tbody> 
                   <?php 
                   while($row = $sql->fetch(PDO::FETCH_ASSOC)) :
                         $nom=$row['nom'];
                         $prenom=$row['prenom'];
                         $mail=$row['mail'];
                         $rpps=$row['rpps'];
                         $tel=$row['telephone'];
                         $id=$row['id'];
                         $dateCrea=$row['dateCreation'];
                         $dateDip=$row['dateDiplome'];
                         

                        //  if (isset($_SESSION['username'])){$username=$_SESSION['username'];}
                   ?>
                    <!-- Corps du tableau -->
                       <tr>
                           <td><?php echo $nom ?></td>
                           <td class="td"><?php echo $prenom?></td> 
                           <td><?php echo $dateCrea?></td>                          
                           <td><?php echo $mail?></td>
                           <td><?php echo $tel ?></td>
                           <td><?php echo $rpps ?></td>
                           <td><?php echo $dateDip ?></td>
                           <td><a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=validateur&action=AccepteMedecin&id=<?php echo $id ?>"style="color:#0000FF;">Accepter</a>  / <a href="suppression_article.php?id=<?php echo $id ?>" onclick="return confirm('Voulez vous vraiment refuser ce médecin ?');"style="color:#FF0000;">Refuser</a> </td>
                           
                       </tr>
                       <?php endwhile;?>
                   </tbody>
          </table>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>