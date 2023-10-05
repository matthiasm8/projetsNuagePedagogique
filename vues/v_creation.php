
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
						<legend>je suis médecin, je souhaite créer un compte</legend>
							<form method="post" action="index.php?uc=creation&action=valideCreation">
                                                            <input name="login" class="form-control" type="email" placeholder="mail"/>
							    <input name="mdp" class="form-control" type="password" placeholder="password"/>
                                                            <input name="prénom" class="form-control" type="text" placeholder="prénom"/>
                                                            <input name="nom" class="form-control" type="text" placeholder="nom"/>
                                                            <input type="checkbox" name="VerifCheckBox" value="1"><strong>J'atteste avoir lu et accepter notre</strong><a href="vues/v_politiqueprotectiondonnees.html"> politique de protection des données
								<br>
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