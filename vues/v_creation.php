<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Inscription - GSB extranet</title>
  </head>

  <body background="assets/img/laboratoire.jpg">

<div class="page-content container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-wrapper">
				<div class="box">
						
                                    <div class="content-wrap">
						<legend>je suis médecin, je souhaite créer un compte</legend>
							<form method="post" action="index.php?uc=creation&action=valideCreation">
              <input name="login" class="form-control" type="email" placeholder="Adresse Mail"/>
							                                              <br><input name="mdp" class="form-control" type="password" required pattern='#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W){12,}#' placeholder="Mot de Passe"/>
                                                            
                                                              <div class="col">
                                                            <input name="prenom" class="form-control" type="text" placeholder="Prénom" pattern="\w{1,30}" required/>
                                                            <input name="nom" class="form-control" type="text" placeholder="Nom" pattern="\w{1,30}" required/>
                                                              </div>  
                                                          
                                                            <input name="telephone" class="form-control" type="int" placeholder="N° de téléphone" pattern="[0]{1}[0-9]{9}" required/>
                                                              <label for='datenaiss'>Date de Naissance :</label>
                                                            <input name="datenaiss" class="form-control" type="date" placeholder="date de naissance" required/>
                                                            <br><input name="rpps" class="form-control" type="int" placeholder="Numéro RPPS" pattern="\d{10}" required/>
                                                            <br><label for='datediplome'>Date d'obtention du diplôme :</label><input name="datediplome" class="form-control" type="date" placeholder="date diplôme" required/>    
                <div class="form-check">
                  <input type='hidden' value='0' name='checkbox'>
                  <input class="form-check-input"type='checkbox' value='1' id="flexCheckDefault" name="checkbox" required>
                    <label class="form-check-label" for="flexCheckDefault" >
                    J'atteste avoir lu et accepte notre <a href="vues/v_politiqueprotectiondonnees.php" style="color:blue;"target="_blank">politique de protection des données</a>
                    </label>
                </div>
                </br>
                  <input type="submit" class="btn btn-primary signup" value="Créer"/>
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