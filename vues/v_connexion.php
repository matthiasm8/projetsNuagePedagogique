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
						<legend>Se connecter</legend>
							<form method="post" action="index.php?uc=connexion&action=valideConnexion">
								<input name="login" class="form-control" type="text" placeholder="Login">
								<input name="mdp" class="form-control" type="password" placeholder="Password">
								</br>
								<input type="submit" class="btn btn-primary signup" value="Se connecter">
							</form>
							</br>
						<a href="index.php?uc=creation&action=demandeCreation">je suis médecin, je souhaite créer un compte</a>
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