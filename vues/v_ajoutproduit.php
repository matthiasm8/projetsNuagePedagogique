<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Ajout d'un Produit - GSB extranet</title>
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
						<legend>Ajouter un produit</legend>
							<form method="post" action="index.php?uc=cdp&action=valideproduit" enctype="multipart/form-data">
								<input name="nom" class="form-control" type="text" placeholder="Nom du produit">
								<input name="objectif" class="form-control" type="text" placeholder="Objectif">
                                <input name="info" class="form-control" type="text" placeholder="Informations">
                                <input name="effet" class="form-control" type="text" placeholder="Effets indésirables">
								</br>
                                <input type="file" name="image" id="image" accept=".png, .jpeg, .gif, .jpg" onchange="fileValidation();"/>
                                <br>
								<input type="submit" class="btn btn-primary signup" value="Ajouter le produit">
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