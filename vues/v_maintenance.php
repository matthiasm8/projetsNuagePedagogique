<?php $bouton='Activer la maintenance';if ($med['etat']==1){$bouton='Arrêter la maintenance';}?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Programmer une maintenance - GSB extranet</title>
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
						<legend>Maintenance du site</legend>
							<form method="post" action="index.php?uc=admin&action=validemaintenance">
                                <!-- <label for="date">Date de la maintenance : <br>(A venir dans la mise à jour d'octobre)</label>
								<input name="date" class="form-control" type="date" value="" readonly ></br>
                                <label for="heure">Heure de la maintenance : <br>(A venir dans la mise à jour d'octobre)</label>
                                <input type="time" name="heure" readonly /></br>
								</br> -->
								<input type="submit" class="btn btn-primary signup" value="<?php echo $bouton;?>" onclick="return confirm('Veuillez confirmer cette action');">
							</form>
							</br>
                                                
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