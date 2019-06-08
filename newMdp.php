<?php
$nomSend = htmlspecialchars($_POST["NomField"]);
$prenomSend = htmlspecialchars($_POST["PrenomField"]);
$codeTemporaire = htmlspecialchars($_POST["CodeTemporaire"]);


$nomPrenom = $nomSend . ' ' . $prenomSend;


 sleep(1);



if($nomSend != "" && $prenomSend!="" && $codeTemporaire != ""){
        //OK on lance l'assaut au serveur
        // Données à envoyer sous la forme d'un array
        // A part l'URL, et éventuellement les options, il n'y aurait que ce tableau à modifier
        $post = array(
            'Nom' => $nomPrenom,
            'CodeTemporaire' => $codeTemporaire,
        );


     
        $data = http_build_query($post);
        $content = file_get_contents(
            'https://a2l-jl.com/api/checkCodeTemporaire.php',
            FALSE,
            stream_context_create(
             array(
                  'http' => array(
                     'method' => 'POST',
                        'header' => "Content-type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen($data) . "\r\n",
                        'content' => $data,
                    )
                )
         )
        );
        

        $response = json_decode( $content, true);
        if($response == "Success") { // connexion réussie 
            ?>
            <!DOCTYPE html>
            <html>
                <head>
                <meta charset="utf-8">
                <title>Réinitialisation de mot de passe</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
                </head>

                <body>
                    <header>
                        
                        <p><a href="homePageAdmin.php"><img src="source/logo.JPG" alt="logo de l'A2L" title="Se déconnecter" class="logo"/></a></p>
                        <p>Créer ou réinitialiser votre mot de passe</p>
                            
                            
                    </header>
                    <section>
                        <article>
						<form method="post" action="source/validerMdp.php">
							<p><label for="Prénom">Nouveau mot de passe</label> : <input type="password" name="Mdp" id="PrenomField" placeholder="Nouveau mot de passe" class="input"/></p>
							
							<p><label for="Prénom">Confirmer</label> : <input type="password" name="MdpConfirm" id="PrenomField" placeholder="Confirmer le nouveau mot de passe" class="input"/></p>
                            <input type="hidden" name="CodeTemporaire" value="<?PHP echo $codeTemporaire;?>"/>
                            <input type="hidden" name="Nom" value="<?PHP echo $nomPrenom;?>"/>
					<input type="submit" value="Valider" class="connexionButton"/>
					</form>
                            <p><a href="#" title="En savoir plus ?" class="annuler" onclick="info()">Et la sécurité dans tout ça ?</a></p>
                            <script>
                                function info(){
                                    alert("L'A2L à mis le paquet sur la sécurité ! Tout d'abord la connexion au site est totalement chiffrée et sécurisée comme en témoigne le petit cadenas et 'httpS'.\nMais ce n'est pas tout !! Les mots de passes sont hasher avec 2 méthodes de hashage. La première est effectuée afin de sécurisé la transmission de données. Ainsi, aucune intersaption de mot de passe est possible. Ensuite votre mot de passe est hasher une seconde fois avec la technique de hashage la plus sûre de notre temps, avec un taux de réussite proche de 99,9%.\nCroyez moi vos informations sont en de bonnes main... a condition que votre mot de passe tienne la route ;)");
                                }
                            </script>
                            <a href="homePageAdmin.php" title="Retour à la page de connexion" class="annuler">Annuler</a>
                        </article>
                    </section>
                    <footer>
			            <div id="footer">
				            <div class="elementFooter">
					            <p><a href="mailto:nathanstchepinsky@gmail.com" title="Signaler un bug"> Signaler un bug</a></p>
				            </div>
				            <div class="elementFooter">
					            <p><a href="" title="Aide">Un peu d'aide ?</a></p>
				            </div>
				            <div class="elementFooter">
                                <p>Ce site web, et l'application ont été developpés par <a href="http://nathanstchepinsky--nathans1.repl.co" title="Visiter le site du developpeur">Nathan</a></p>
				            </div>
			            </div>
		            </footer>
                </body>
            </html>
            <?PHP
        } else if($response == "Code temporaire faux"){
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Informations incorrects</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="reinitialiseMotDePasse.php" method ="POST", id="connexion">
                    <input type="hidden" value="Votre code temporaire est erroné. Veuillez recommencer" name="error">
                </form>
                <script>
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
            <?PHP
        } else if($response == "Aucun code temporaire"){
           
        ?>
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Informations incorrects</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="reinitialiseMotDePasse.php" method ="POST", id="connexion">
                    <input type="hidden" value="Verifier qu'un code temporaire valide est été créé. Sinon faites le générer par un admin via votre fiche adhérent" name="error">
                </form>
                <script>
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
            <?PHP
        } else if($response == "Accès au serveur refusé"){
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Informations incorrects</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="reinitialiseMotDePasse.php" method ="POST", id="connexion">
                    <input type="hidden" value="ATTENTION. Cette section est formellement réservée au memebre du bureau et super-admin" name="error">
                </form>
                <script>
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
            <?PHP
        } else {
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Informations incorrects</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="reinitialiseMotDePasse.php" method ="POST", id="connexion">
                    <input type="hidden" value="Boh .... Aucune réponse du serveur" name="error">
                </form>
                <script>
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
            <?PHP
        }
    

} else {
    ?>
    <!DOCTYPE html>
    <html>
	    <head>
		    <meta charset="utf-8">
		    <title>Echec de connexion</title>
		    <link rel="stylesheet" href="source/style.css"/>
		    <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
	</head>

	<body>
        <form action="reinitialiseMotDePasse.php" method ="POST", id="connexion">
            <input type="hidden" value="Une erreur est survenue" name="error">
        </form>
        <script>
            document.forms["connexion"].submit();
        </script>
    </body>
    </html>
<?PHP } ?>