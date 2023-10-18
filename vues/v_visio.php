<?php
if (!$_SESSION['id'])
    header('Location: ../index.php');
else 
?>
﻿<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    <title>GSB -extranet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/profilcss/profil.css" rel="stylesheet">
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

  <?php 
    $pdo = PdoGsb::$monPdo;
    $sql=$pdo->prepare("SELECT * FROM medecin WHERE valide=1 ");
    $sql->execute();
?>

  <?php
         $pdo = PdoGsb::$monPdo;
         $sql=$pdo->prepare("SELECT * FROM visioconference WHERE dateVisio > now()");
         $sql->execute();
         
     
        ?>

<nav class="navbar navbar-default">
<h1> Tableau a embellir (bootstrap card par exemple)</h1>
    <table id="myTable" class="table table-hover">
                   <caption><center>Visioconférences à venir :</center></caption>
                   <thead> <!-- En-tête du tableau -->
                       <tr id="tr" class="tr bg-success text-white" >
                           <th onclick="sortTable(1)" scope="col" >Nom de la visio</th>
                           <th onclick="sortTable(2)" scope="col" >Objetif</th>
                           <th onclick="sortTable(3)" scope="col" >URL</th>
                           <th onclick="sortTable(1)" scope="col" >Date de la visio</th>

                        </tr>
                   </thead>
                   <tbody> 
                   <?php 
                   while($row = $sql->fetch(PDO::FETCH_ASSOC)) :
                         $nom=$row['nomVisio'];
                         $objectif=$row['objectif'];
                         $url=$row['url'];
                         $date=$row['dateVisio'];



                        //  if (isset($_SESSION['username'])){$username=$_SESSION['username'];}
                   ?>
                    <!-- Corps du tableau -->
                       <tr>
                           <td><?php echo $nom ?></td>
                           <td><?php echo $objectif ?></td>
                           <td><?php echo $url ?></td>
                           <td><?php echo $date ?></td>
                           <td><a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=validateur&action=AccepteMedecin&id=<?php echo $id ?>"style="color:#0000FF;">S'inscrire</a>


                           
                       </tr>
                       <?php endwhile;?>
                   </tbody>
          </table>
  </div><!-- /.container-fluid -->
</nav>



	
	<div class="page-content">
    	<div class="row">

<?php ;?>
