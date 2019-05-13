<?php
session_start();
$nom = $_SESSION['NomAdmin'];
$prenom = $_SESSION['PrenomAdmin'];
$mdp = $_SESSION['MdpAdmin'];

$nomPrenom = $nom . ' ' . $prenom;

$nomAdherent = $_GET['NomAdherent'];
$dateNaissanceAdherent = $_GET['DateNaissance'];


if($mdp != "" && $nomPrenom != ""){
     //OK on lance l'assaut au serveur
        // Données à envoyer sous la forme d'un array
        // A part l'URL, et éventuellement les options, il n'y aurait que ce tableau à modifier
        $post = array(
            'Nom' => $nomAdherent,
            'DateNaissance' => $dateNaissanceAdherent,
        );


     
        $data = http_build_query($post);
        $content = file_get_contents(
            'https://a2l-jl.com/api/infoAdherent.php',
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

        


        if($content.is_array() && (json_decode( $content, true)[0]['id'] != "")){ // connexion réussie
            $arrayData = json_decode( $content, true);
            //echo json_decode( $content, true)[0]['id'];
            //echo $content
            $id = $arrayData[0]['id'];
            $nom = $arrayData[0]['Nom'];
            $dateNaissance = $arrayData[0]['DateNaissance'];
            $classe = $arrayData[0]['Classe'];
            $statut = $arrayData[0]['Statut'];
            $pointsFidelite = $arrayData[0]['PointFidelite'];


            $listeDate = explode("/", $dateNaissance);

            $key = ($listeDate[0] + $listeDate[1] + $listeDate[2]) % 10;

            $QRcodeText = $nomPrenom . '%23' . $dateNaissance . '%23' . $key;

            $QRcode = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $QRcodeText . '&choe=UTF-8';

            //Load de l'image loadImage.php
            $post = array(
                'idAdherent' => $id,
            );
            $data = http_build_query($post);
            $content = file_get_contents(
                'https://a2l-jl.com/api/loadImage.php',
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
            $imageData = json_decode($content); 
            

           
            ?>
            <!DOCTYPE html>
            <html>
                <head>
                <meta charset="utf-8">
                <title>Fiche adhérent</title>
                <link rel="stylesheet" href="source/styleFicheAdherent.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
                </head>

                <body>
                    <header>
                        <div id="header">
                            <div class="elementHeader">
                                <form action="ficheAdmin.php" method ="POST", id="connexion">
                                    <input type="hidden" value="SESSION_STARTED" name="NomField">
                                </form>
                                    <p><a href="homePageAdmin.php"><img src="source/logo.JPG" alt="logo de l'A2L" title="Se déconnecter" class="logo"/></a></p>
                                    <p><a href="ficheAdmin.php" title="Accéder à ma fiche admin" onclick='javascript.document.forms["connexion"].submit();'>Fiche administrateur de l'A2L</a></p>
                                    <script>
                                        function postData(){
                                            
                                        }
                                    </script>
                            </div>
                            <div class="elementHeader">
                            <p><a href="listeAdherent.php" onclick='javascript.document.getElementById("afficheListe").submit()'><img src="source/liste.jpg" alt="Image d'une liste et un crayon" title="Acceder à la liste adhérent" class="liste"/></a></p>
                            <p><a href="listeAdherent.php" title="Acceder à la liste adhérent">Accéder à la liste des adhérents</a></p>
                            </div>
                        </div>
                    </header>
                    <section>
                        <article>
                        <h1 class="h1"> <?php echo $nom; ?></h1>
                            <p class="pdp"><?PHP echo '<img src="data:image/jpeg;base64,' . $imageData . '" class="logo">'; ?></p>
                            <p>Date de naissance : <strong> <?PHP echo $dateNaissance; ?> </strong> </p>
                            <p>Classe : <strong> <?PHP echo $classe; ?> </strong> </p>
                            <p>Statut: <strong> <?PHP echo $statut; ?> </strong> </p>
                            <form action="source/validerPointFidelite.php" method="post">
                                <p>Points de fidélité : <input type="number" min="0" max="10" step="1" value="<?PHP echo $pointsFidelite; ?>" class="pointFidelite" name="PointFidelite"/> <input type="submit" value="Valider" class="pointFidelite"/></p>
                                <input type="hidden" name="url" value="https://a2l-jl.com/infoAboutAdherent.php?NomAdherent=<?PHP echo $nomAdherent;?>&DateNaissance=<?PHP echo $dateNaissanceAdherent; ?>"/>
                                <input type="hidden" name="idAdherent" value="<?PHP echo $id;?>"/>
                            </form>
                            <p><?PHP echo '<img src="'.$QRcode.'">'; ?></p>
                            <p><a href="homePageAdmin.php" title="Retour à la page de connexion" onclick='<?PHP /*session_destroy();*/?>'>Déconnexion</a></p>
                        </article>
                    </section>
                    <footer>
			            <div id="footer">
				            <div class="elementFooter">
					            <p><a href="href="mailto:nathanstchepinsky@gmail.com title="Signaler un bug"> Signaler un bug</a></p>
				            </div>
				            <div class="elementFooter">
					            <p><a href="" title"Aide">Qu'est ce que l'A2L ?</a></p>
				            </div>
				            <div class="elementFooter">
                                <p>Ce site web, et l'application on été developpés par <a href="http://nathanstchepinsky--nathans1.repl.co" title="Visiter le site du developpeur">Nathan</a></p>
				            </div>
			            </div>
		            </footer>
                </body>
            </html>
            <?PHP
        } else if($content == "\"Mdp incorrect\""){
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
                <form action="homePageAdmin.php" method ="POST", id="connexion">
                    <input type="hidden" value="Oups.... Mot de passe incorrect" name="error">
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
                <form action="homePageAdmin.php" method ="POST", id="connexion">
                    <input type="hidden" value="Oups ... Vous n'avez pas les droits necessaires" name="error">
                </form>
                <script>
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
            <?PHP
        }
}else {

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
        <form action="homePageAdmin.php" method ="POST", id="connexion">
            <input type="hidden" value="Oups ... On dirait bien que votre session a expiré" name="error">
        </form>
        <script>
            document.forms["connexion"].submit();
        </script>
    </body>
    </html>
<?PHP } ?>