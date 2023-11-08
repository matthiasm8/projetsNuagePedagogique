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
         $sql=$pdo->prepare("SELECT * FROM produit");
         $sql->execute();
         
     
        ?>
<div class="row">
<h3> Produits disponibles </h3>
<?php $counter = 1;
      while($row = $sql->fetch(PDO::FETCH_ASSOC)) :
                         $nom=$row['nom'];
                         $objectif=$row['objectif'];
                         $info=$row['information'];
                         $effet=$row['effetIndesirable'];
                         $img=$row['image'];
                         $id=$row['id'];
                         
                         $button_id = "showContentButton_$counter";
                         $card_id = "card_$counter";
    ?>
  <div class="col-sm-2">                        
    <div class="card bg-transparent" >
      <?php if (!empty($row['image'])){?><img src="./images_produits/<?php echo $img?>"  class="card-img-top" height="200px"><?php } else {?> <img src="./images_produits/default.png"  class="card-img-top" height="200px"> <?php }?></td>

      <div class="card-body bg-primary">
        <h5 class="card-title fw-bold"><?php echo $nom;?></h5>

      </div>
      <a data-action-url="index.php?uc=produits&action=info&id=<?php echo $id; ?>" class="btn btn-light show-button" id="<?php echo $button_id; ?>" onclick="callMyFunction(event)">Afficher les informations</a>
      <div class="card-body bg-primary <?php echo $card_id; ?> hidden">
                
        <p class="card-text"><?php echo $objectif;?></p>
        <p class="card-text">Informations : <br><?php echo $info;?></p>
        <p class="card-text">Effets Indésirables : <br><?php echo $effet;?></p>
        <?php if($_SESSION['role']==5){
        $sqle=$pdo->prepare("SELECT * FROM medecinproduit WHERE idProduit=:idP && idMedecin=:idM && action='aimer'");
        $bv1 = $sqle->bindValue(':idM', $_SESSION['id']);
        $bv1 = $sqle->bindValue(':idP', $id);
        $sqle->execute();
        $a=$sqle->rowCount();

        if ($a==0){
        ?>
        <a data-action-url="index.php?uc=produits&action=aimer&id=<?php echo $id; ?>" class="btn btn-light like-button" onclick="callMyFunction(event)">Aimer ce produit</a>
      <?php }
    else echo '<div class="card-body bg-secondary">
    <p> Vous avez déjà aimé ce produit !</p>
  </div>';
    
    }?>
      </div>
      <?php if($_SESSION['role']==2){?>
        <div class="card-body bg-secondary">
          <a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=cdp&action=modifieproduit&id=<?php echo $id ?>" class="card-link" style="color:#0000FF;">Modifier</a>
          <a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=cdp&action=supprimeproduit&id=<?php echo $id ?>" class="card-link" style="color:red;" onclick="return confirm('Voulez vous vraiment supprimer ce produit ?');">Supprimer</a>
        </div>
      <?php }?>
    </div>
  </div>
<?php $counter++; endwhile;?>
</div>





	
	<div class="page-content">
    	<div class="row">

<?php ;?>

<script>
$(document).ready(function() {
  $("[id^=showContentButton_]").click(function() {
    // Récupérez l'ID du bouton cliqué
    var button_id = $(this).attr("id");
    // Récupérez le numéro de la carte à afficher
    var card_num = button_id.split("_")[1];
    // Affichez la carte correspondante
    var card_id = "card_" + card_num;
    $("." + card_id).removeClass("hidden");
    $(this).addClass("hidden");
  });
});
</script>

<script>
$(document).ready(function() {
  $(".show-button").click(function(e) {
    e.preventDefault(); // Empêche le comportement par défaut du lien

    var actionUrl = $(this).data("action-url");

    $.ajax({
      url: actionUrl,
      type: "GET", // Vous pouvez utiliser POST si nécessaire
      success: function(response) {
        // Traitez la réponse du serveur ici
        // Vous pouvez mettre à jour le contenu de la carte, etc.
      },
      error: function(xhr, status, error) {
        // Gérez les erreurs en cas d'échec de la requête AJAX
      }
    });
  });
});
</script>

<script>
$(document).ready(function() {
  $(".like-button").click(function(e) {
    e.preventDefault(); // Empêche le comportement par défaut du lien

    var actionUrl = $(this).data("action-url");
    
    $.ajax({
      url: actionUrl,
      type: "GET", // Vous pouvez utiliser POST si nécessaire
      success: function(response) {
        // Traitez la réponse du serveur ici
        // Vous pouvez mettre à jour le contenu de la carte, etc.
      },
      error: function(xhr, status, error) {
        // Gérez les erreurs en cas d'échec de la requête AJAX
      }
    });
  $(this).addClass("hidden");
  });
});
</script>

