<?php $mail = $_GET['mail'];?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Confirmer l'inscription à GSB extranet</title>
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
						<legend>Validation du compte</legend>
            Veuillez entrer le code envoyé à l'adresse <?php echo $mail?>.
							<form method="post" action="index.php?uc=validation&action=validationCompte&mail=<?php echo $mail?>">
								<input name="token" class="form-control" type="text" data-pattern="{6}" value="">
								</br>
								<input type="submit" class="btn btn-primary signup" value="Valider mon compte">
							</form>
							</br>
						<a href="../index.php?uc=creation&action=demandeCreation">Je n'ai pas reçu mon code</a>
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