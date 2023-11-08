<?php
if (!$_SESSION['id'])
    header('Location: ../index.php');
else {

  switch($_SESSION['role']){
	
    case 5:{
         $role='Médecin';
         $uc='medecin';
         break;
    }

    case 4:{
      $role='Validateur';
      $uc='validateur';
      break;
    }

    case 3:{
      $role='Administrateur';
      $uc='admin';
      break;
    }

    case 2:{
      $role='Chef de produit';
      $uc='cdp';
      break;
    }

    case 1:{
      $role='Modérateur';
      $uc='moderateur';
      break;
    }
  }
?>
﻿<!DOCTYPE html>
<html lang="fr">
<head>
  <script src="https://code.jquery.com/jquery.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link href="css/styles.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top navbar-light bg-primary">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php?uc=<?php echo $uc?>"><img src="./assets/img/LOGO-GSB.png" alt="Bootstrap" width="90" height="50"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      <?php if (($_SESSION['role']!=4)&&($_SESSION['role']!=1))  {?>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Produits
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?uc=produits&action=listeproduits">Liste des Produits</a></li>
            <?php if($role=='Chef de produit'){echo '<li><a class="dropdown-item" href="index.php?uc=cdp&action=ajoutproduit"> Ajouter un produit</a></li>';}?>
          </ul>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Visios
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?uc=visios&action=listevisios">Liste des Visios</a></li>
            <?php if($role=='Chef de produit'){echo '<li><a class="dropdown-item" href="index.php?uc=cdp&action=ajoutvisio"> Ajouter une visio</a></li>';}?>
            <?php if($role=='Médecin'){echo '<li><a class="dropdown-item" href="index.php?uc=medecin&action=mesvisio"> Mes visioconférences</a></li>';}?>
          </ul>
      </li>
      <?php }?>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $role?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?uc=<?php echo $uc?>">Accueil <?php echo $role?></a></li>
          </ul>
      </li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
      <span class="navbar-text"><?php echo $_SESSION['prenom']."  ".$_SESSION['nom']?></span>
      <!-- <li><a href="index.php?uc=<?php echo $uc?>">Portail <?php echo $role?></a></li> -->
      <li><a href="index.php?uc=deconnexion&action=deconnexion">Se déconnecter</a></li>
       
     </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



	
	<div class="page-content">
    	<div class="row">

<?php };?>
