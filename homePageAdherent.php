<?php
session_start();
$_SESSION = array();
session_destroy();

$error = htmlspecialchars($_POST["error"]);


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>A2L connexion adhérents</title>
		<link rel="stylesheet" href="source/style.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
	</head>

	<body>
	<header>
        <p><a href="homePageAdherent.php"><img src="source/images/logo.JPG" alt="logo de l'A2L" title="Se déconnecter"/></a></p>
        <p>Site officiel de l'A2L</p>
        </header>
		<section>
			<article>
				<?PHP
					if($error != ""){
						sleep(1);?>
						<h1 class="h1error"><?PHP echo $error; ?></h1>
					<?PHP } else { ?>
						<h1 class="h1">Connexion des adhérents</h1>
					<?PHP } ?>
			</article>
			<article>
				<form method="post" action="ficheAdherent.php">
					<div id="connexion">
						<div class="elementConnexion">
							<p>
								<?PHP
								if($error != ""){?>
									
									<label for="Prénom">Prénom</label> : <input type="text" name="PrenomField" id="Prénom" placeholder="Prénom" class="inputError"/>
								<?PHP } else {
									?> <label for="Prénom">Prénom</label> : <input type="text" name="PrenomField" id="Prénom" placeholder="Prénom" class="input"/> <?PHP
									}?>
							</p>
						</div>
						<div class="elementConnexion">
							<p>
							<?PHP
								if($error != ""){?>
									<label for="Nom">Nom</label> : <input type="text" name="NomField" id="Nom" placeholder="Nom" class="inputError"/>
								<?PHP } else {
									?> <label for="Nom">Nom</label> : <input type="text" name="NomField" id="Nom" placeholder="Nom" class="input"/> <?PHP
									}?>
								
							</p>
						</div>
					</div>
					<p>
					<?PHP
						if($error != ""){?>			
							<label for="DateNaissance">Date de naissance </label> : <input type="text" name="DateNaissanceField" id="DateNaissance" class="inputError" placeholder="✘✘dd/mm/yyyy✘✘"/>
						<?PHP } else {
							?> <label for="DateNaissance">Date de naissance</label> : <input type="text" name="DateNaissanceField" id="DateNaissance" class="input" placeholder="✘✘dd/mm/yyyy✘✘"/> <?PHP
						}?>
						
					</p>
					<input type="submit" value="Connexion" class="connexionButton">
					</form>
					
			</article>
			<article>
				<h4>Pour plus d'informations adressez-vous à un membre du bureau !</h3>
				<h3>Je suis admin et je réclame mes droits ! <a href="homePageAdmin.php" title="Page de connexion pour les adhérents">Connecte toi ici alors</a>
			</article>
		</section>

		<footer>
			<div id="footer">
				<div class="elementFooter">
					<p><a href="mailto:nathanstchepinsky@gmail.com" title="Signaler un bug"> Signaler un bug</a></p>
				</div>
				<div class="elementFooter">
					<p><a href="pageAide.php" title="Aide">Un peu d'aide ?</a></p>
				</div>
				<div class="elementFooter">
					<p>Ce site web, et l'application ont été developpés par <a href="http://nathanstchepinsky--nathans1.repl.co" title="Visiter le site du developpeur">Nathan</a></p>
				</div>
			</div>
		</footer>
	</body>
</html>

<?php 
?>