<?PHP
$listeTitreSecurite = ["Qui a accès à mes informations ?", "Comment sont stockés mes informations ?", "Comment sont stockés les mots de passe ?", "Est-ce que 'Open Source' signifie que tout le monde a accès à mes données ?", "[Avancé] Comment l'accès au serveur est-il géré ?"];
$listeTitreAboutUsing = ["A quoi sert le QR code ?", "Qui sont les membres du bureau ?", "Pourquoi me demande-ton ma date de naissance ?", "[Admin] Quels sont mes privilèges ?", "[Admin] Comment devenir admin ?", "[Admin] Quels sont les critères requis pour ajouter un adhérent", "[Admin] Qu'est ce que le code temporaire ?", "[Admin] Comment créer ou modifier un mot de passe ?", "[Admin] Que se passe-t-il lorsqu'un admin perd son grade ?"];
$listeTitreError = ["Impossible de me connecter car mon mot de passe est incorrect", "Impossible de me connecter car l'accès est refusé", "Impossible de me connecter : Le serveur ne répond pas", "Impossible de me connecter au cause d'une erreur inconnue"];
$listeTitreSite = ["Que siginfie open source ?", "Comment participer au projet ?", "Comment le serveur fonctionne-t-il ?", "Information de développement"];



?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Page d'aide</title>
		<link rel="stylesheet" href="source/stylePageAide.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
	</head>

	<body>
		<header>
            <p><a href="index.php"><img src="source/images/logo.JPG" alt="logo de l'A2L" title="Se déconnecter" class="logo"/></a></p>
            <p>● Page d'aide</p>
            <p><a href="index.php"> < Retour</a></p>
        </header>
		<section>
			<article>
                <h1>Un talent à faire valoir ? Participe à ta façon au projet de l'A2L !!</h1>
                <h3><strong>Petit mot du développeur :</strong> Le projet de l'A2L n'en est qu'à son début ! Si tu as une idée, n'hésites pas et fait comme moi ! Participe à l'éllaboration de ce projet. Tout est bon a prendre. Débutants comme experts soyez les bienvenus :</h3>
                    <div id="projet">
                        <div class="projetElement">
                            <p><img src="source/images/pen.png" alt="Crayon de couleur noire"/><br /><a href="https://github.com/DevNathan/A2L_siteWeb" class="lienAide">Accèder au code source du site web</a></p>
                        </div>
                        <div class="projetElement">
                            <p><img src="source/images/pen.png" alt="Crayon de couleur noire"/><br /><a href="https://github.com/DevNathan/A2L_iOSApplication" class="lienAide">Accèder au code source de l'application</a></p>
                        </div>
                        <div class="projetElement">
                            <p><img src="source/images/pen.png" alt="Crayon de couleur noire"/><br /><a href="https://github.com/DevNathan/A2L_BackEnd" class="lienAide">Accéder au code source du serveur de l'A2L</a></p>
                        </div>
                        <div class="projetElement">
                            <p><img src="source/images/pen.png" alt="Crayon de couleur noire"/><br /><a href="mailto:nathanstchepinsky@gmail.com?subject=Oups ! J'ai repéré un bug !!" class="lienAide">Signaler un bug</a></p>
                        </div>
                        <div class="projetElement">
                            <p><img src="source/images/pen.png" alt="Crayon de couleur noire"/><br /><a href="mailto:nathanstchepinsky@gmail.com?subject=J'ai un message pour toi !!" class="lienAide">Contacter le développeur</a></p>
                        </div>
                        <div class="projetElement">
                            <p><img src="source/images/pen.png" alt="Crayon de couleur noire"/><br /><a href="https://nathanstchepinsky--nathans1.repl.co" class="lienAide">Visiter le site web du développeur</a></p>
                        </div>
                    </div>
			</article>
			<article>
				<h1>Besoin d'aide ?</h1>
                <h2>Sécurité</h2>
                <div id="securite">
                    <?PHP
                    for($count = 0; $count<count($listeTitreSecurite);$count++){
                        ?>
                            <div class="securiteElement">
                                <p><img src="source/images/empreinteDigitale.png" alt="Empreinte digitale rouge"/><br /><a href="afficheAide.php?section=securite&titre=<?PHP echo $listeTitreSecurite[$count];?>" class="lienAide"><?PHP echo $listeTitreSecurite[$count];?></a></p>
                            </div>
                        <?PHP
                    } ?>
                </div>
                <h2>Utilisation du site</h2>
                <div id="utilisation">
                <?PHP
                    for($count = 0; $count<count($listeTitreAboutUsing);$count++){
                        ?>
                        <div class="utilisationElement">
                            <p class="using"><img src="source/images/ordinateur.png" alt="Ordinateur bleu"/><br /><a href="afficheAide.php?section=utilisation&titre=<?PHP echo $listeTitreAboutUsing[$count];?>" class="lienAide"><?PHP echo $listeTitreAboutUsing[$count];?></a></p>
                        </div>
                        <?PHP
                    }
                ?>
                </div>
                <h2>Les erreurs rencontrées</h2>
                <div id="erreur">
                <?PHP
                    for($count = 0; $count<count($listeTitreError);$count++){
                        ?>
                        <div class="erreurElement">
                            <p class="error"><img src="source/images/croix.png" alt="Croix verte"/><br /><a href="afficheAide.php?section=erreur&titre=<?PHP echo $listeTitreError[$count];?>" class="lienAide"><?PHP echo $listeTitreError[$count];?></a></p>
                        </div>
                        <?PHP
                }
                ?>
                </div>
                <h2>À propos du site</h2>
                <div id="aPropos">
                    <?PHP
                    for($count = 0; $count<count($listeTitreSite);$count++){
                    ?>
                        <div class="aProposElement">
                            <p class="info"><img src="source/images/atom.png" alt="Atome violet"/><br/><a href="afficheAide.php?section=a_propos&titre=<?PHP echo $listeTitreSite[$count];?>" class="lienAide"><?PHP echo $listeTitreSite[$count];?></a></p>
                        </div>
                        <?PHP
                    }
                ?>
                </div>
			</article>
			
		</section>
		<footer>
			<div id="footer">
				<div class="elementFooter">
					<p><a href=mailto:nathanstchepinsky@gmail.com title="Signaler un bug"> Signaler un bug</a></p>
				</div>
				<div class="elementFooter">
					<p><a href="#" title="Aide">Un peu d'aide ?</a></p>
				</div>
				<div class="elementFooter">
					<p>Ce site web, et l'application on été developpés par <a href="http://nathanstchepinsky--nathans1.repl.co" title="Visiter le site du developpeur">Nathan</a></p>
				</div>
			</div>
		</footer>
	</body>
</html>


