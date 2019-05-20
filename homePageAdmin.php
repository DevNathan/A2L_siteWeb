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
		<title>A2L connexion admin</title>
		<link rel="stylesheet" href="source/style.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>

	</head>

	<body>
		<header>
        	<p><a href="homePageAdherent.php"><img src="source/logo.JPG" alt="logo de l'A2L" title="Se déconnecter"/></a></p>
        	<p>Site officiel de l'A2L</p>
        </header>
		<section>
			<article>
			<?PHP
					if($error != ""){
						sleep(1);?>
						<h1 class="h1error"><?PHP echo $error; ?></h1>
					<?PHP } else { ?>
						<h1 class="h1">Chères membres du bureau, bienvenue</h1>
					<?PHP } ?>
				<h2>Cette version web est une version restreinte de l'application A2L, disponible pour tous, en attendant la fin de son élaboration.  L'application pour iOS est déjà <a href="" title="Accéder à l'application iOS de l'A2L">disponible</a>!!</h2>
			</article>
			<article>
				<div id="connexion">
					<div class="elementConnexion">
						<form method="post" action="ficheAdmin.php">
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
							<label for="Mdp">Mot de passe </label> : <input type="password" name="MdpField" id="Mdp" class="inputError" placeholder="Mot de passe"/>
						<?PHP } else {
							?> <label for="Mdp">Mot de passe</label> : <input type="password" name="MdpField" id="Mdp" class="input" placeholder="Mot de passe"/> <?PHP
						}?>
						
					</p>
					<input type="submit" value="Connexion" class="connexionButton">
					</form>
			</article>
			<article>
				<h4>Si vous avez perdu votre mot de passe ou que vous n'en avez pas alors pas de bol ......</h4>
				<h4>Allez je suis sympa ... Rendez-vous <a href="reinitialiseMotDePasse.php">ici</a> ;)</h4>
				<h3>Je suis adhérent et je comprends rien du tout :( <a href="homePageAdherent.php" title="Page de connexion pour les adhérents">Connecte toi ici alors</a></h3>
			</article>
		</section>
		<footer>
			<div id="footer">
				<div class="elementFooter">
					<p><a href=mailto:nathanstchepinsky@gmail.com title="Signaler un bug"> Signaler un bug</a></p>
				</div>
				<div class="elementFooter">
					<p><a href="" title="Aide">Qu'est ce que l'A2L ?</a></p>
				</div>
				<div class="elementFooter">
					<p>Ce site web, et l'application on été developpés par <a href="http://nathanstchepinsky--nathans1.repl.co" title="Visiter le site du developpeur">Nathan</a></p>
				</div>
			</div>
		</footer>
	</body>
</html>


