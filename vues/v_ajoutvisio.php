<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Ajout d'une Visio - GSB extranet</title>
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
						<legend>Ajouter une visioconférence</legend>
							<form method="post" action="index.php?uc=cdp&action=validevisio" enctype="multipart/form-data">
								<input name="nom" class="form-control" type="text" placeholder="Nom de la Visioconférence">
								<input name="objectif" class="form-control" type="text" placeholder="Objectif">
                <label for="url">Lien URL :</label>
                                <input name="url" class="form-control" type="url" pattern="https://.*" placeholder="https://example.com">
                                <label for="date">Date de la visioconférence :</label>
								<input name="date" class="form-control" type="date" value="" ></br>
								</br>

								<input type="submit" class="btn btn-primary signup" value="Ajouter la visio">
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