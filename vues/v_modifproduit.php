<?php

$idprod=$_GET['id'];
$sql="SELECT * FROM produit WHERE ID=$idprod";
      $req=$db->prepare($sql);
      $req->execute();
      $row = $req->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modifier un produit - GSB extranet</title>
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

<div class="page-content container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-wrapper">
				<div class="box">
					<div class="content-wrap">
						<legend>Modifier un produit</legend>
							<form method="post" action="index.php?uc=cdp&action=validemodifproduit&id=<?php echo $idprod?>" enctype="multipart/form-data">
								<input name="nom" class="form-control" type="text" value="<?php echo $row['nom']; ?>" placeholder="Nom du produit">
								<input name="objectif" class="form-control" type="text" value="<?php echo $row['objectif']; ?>" placeholder="Objectif">
                                <input name="info" class="form-control" type="text" value="<?php echo $row['information']; ?>" placeholder="Informations">
                                <input name="effet" class="form-control" type="text" value="<?php echo $row['effetIndesirable']; ?>" placeholder="Effets indésirables">
								</br>
                <label for="image">Ajouter ou remplacer l'image : <br></label>
                                <input type="file" name="image" id="image" accept=".png, .jpeg, .gif, .jpg" value="<?php echo $row['image']; ?>" onchange="fileValidation();"/>
                                <br>
								<input type="submit" class="btn btn-primary signup" value="Modifier le produit">
							</form>
							</br>
                                                <br/>
                                                
                                        </div>	
                                     
                                    
				</div>
			</div>
		</div>
	</div>
</div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>