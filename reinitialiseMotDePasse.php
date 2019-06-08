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
		<title>Réinitialiser mon mot de passe</title>
		<link rel="stylesheet" href="source/style.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>

	</head>

	<body>
		<header>
        	<p><a href="homePageAdherent.php"><img src="source/logo.JPG" alt="logo de l'A2L" title="Se déconnecter"/></a></p>
        	<p>Créer/Réinitiliser mon mot de passe</p>
        </header>
		<section>
			<article>
			<?PHP
					if($error != ""){
						sleep(1);?>
						<h1 class="h1error"><?PHP echo $error; ?></h1>
					<?PHP } else { ?>
						<h1 class="h1">Section réservée au adminisatrateur</h1>
					<?PHP } ?>
				<h2>Cette section est strictement réservée au membre du bureau ou super-admin. Elle sert à la réinitilisation ou la création de mot de passe. Utilisez un code temporaire généré pour vous pour cela.</h2>
			</article>
			<article>
				<div id="connexion">
					<div class="elementConnexion">
						<form method="post" action="newMdp.php">
							<p>
							<?PHP
								if($error != ""){?>
									
									<label for="Prénom">Prénom</label> : <input type="text" name="PrenomField" id="Prénom" placeholder="Prénom" class="inputError"/>
								<?PHP } else {
									?> <label for="Prénom">Prénom</label> : <input type="text" name="PrenomField" id="PrenomField" placeholder="Prénom" class="input"/> <?PHP
									}
									?>
									
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
							<label for="Mdp">Code temporaire</label> : <input type="password" name="CodeTemporaire" id="Mdp" class="inputError" placeholder="4 chiffres"/>
						<?PHP } else {
							?> <label for="Mdp">Code temporaire</label> : <input type="password" name="CodeTemporaire" id="Mdp" class="input" placeholder="4 chiffres"/> <?PHP
						}?>
						
					</p>
					<input type="submit" value="Acceder" class="connexionButton">
					</form>
			</article>
			<article>
				<h4>Afin d'acceder à la page de réinitilisation des mots de passes, vous devez être membre du bureau, super-admin. Un administrateur doit vous générer un code confidentiel temporaire via votre fiche adhérent.</h4>
				<h4>Ce code est à utilisation unique. En accedant à la page de réinitilisation, vous le détruisez instantanément.</h4>
                <h3>Retourner aux pages de <a href="homePageAdherent.php" title="Page de connexion pour les adhérents">connexions</a></h3>
			</article>
		</section>
		<footer>
			<div id="footer">
				<div class="elementFooter">
					<p><a href=mailto:nathanstchepinsky@gmail.com title="Signaler un bug"> Signaler un bug</a></p>
				</div>
				<div class="elementFooter">
					<p><a href="" title="Aide">Un peu d'aide ?</a></p>
				</div>
				<div class="elementFooter">
					<p>Ce site web, et l'application on été developpés par <a href="http://nathanstchepinsky--nathans1.repl.co" title="Visiter le site du developpeur">Nathan</a></p>
				</div>
			</div>
		</footer>
	</body>
</html>


