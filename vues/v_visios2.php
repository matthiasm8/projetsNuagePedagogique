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
