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
		<link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>

	</head>

	<body>
	<?PHP require("source/Class/EtatSite/etat_site.php");
    $etatSite = new EtatSite();
	?>
	<div id="maintenance" style="background:<?PHP echo $etatSite->getColor(); ?>;"><h1 id="etatSite"><?PHP echo $etatSite->getMessage(); ?></h1></div>		
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
						<h1 class="h1">Connexion des membres du bureau</h1>
					<?PHP } ?>
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
					<p><a href="pageAide.php" title="Aide">Un peu d'aide ?</a></p>
				</div>
				<div class="elementFooter">
					<p>Ce site web, et l'application ont été developpés par <a href="http://nathanstchepinsky--nathans1.repl.co" title="Visiter le site du developpeur">Nathan</a></p>
				</div>
			</div>
		</footer>
	</body>
</html>


