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
         $sql=$pdo->prepare("SELECT * FROM produit");
         $sql->execute();
         
     
        ?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    
    <h1> Tableau a embellir (bootstrap card par exemple)</h1>
    <table id="myTable" class="table table-hover">
                   <caption><center></center></caption>
                   <thead> <!-- En-tête du tableau -->
                       <tr id="tr" class="tr bg-success text-white" >
                           <th scope="col" >Nom</th>
                           <th scope="col" >Objectif</th>
                           <th scope="col" >information</th>
                           <th scope="col" >Effet Indésirable</th>
                           <th scope="col" >Image</th>
                        
                        </tr>
                   </thead>
                   <tbody> 
                   <?php 
                   while($row = $sql->fetch(PDO::FETCH_ASSOC)) :
                         $nom=$row['nom'];
                         $objectif=$row['objectif'];
                         $info=$row['information'];
                         $effet=$row['effetIndesirable'];
                         

                        //  if (isset($_SESSION['username'])){$username=$_SESSION['username'];}
                   ?>
                    <!-- Corps du tableau -->
                       <tr>
                           <td><?php echo $nom ?></td>
                           <td><?php echo $objectif ?></td>
                           <td><?php echo $info ?></td>
                           <td><?php echo $effet ?></td>
                            
                           
                       </tr>
                       <?php endwhile;?>
                   </tbody>
          </table>

  </div><!-- /.container-fluid -->
</nav>



	
	<div class="page-content">
    	<div class="row">

<?php ;?>
