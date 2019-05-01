<?php
$nomSend = htmlspecialchars($_POST["NomField"]);
$prenomSend = htmlspecialchars($_POST["PrenomField"]);
$dateSend = htmlspecialchars($_POST["DateNaissanceField"]);

$nomPrenom = $nomSend . ' ' . $prenomSend;

$listeDate = explode("/", $dateSend);

$key = ($listeDate[0] + $listeDate[1] + $listeDate[2]) % 10;

$QRcodeText = $nomPrenom . '%23' . $dateSend . '%23' . $key; 

$QRcode = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $QRcodeText . '&choe=UTF-8';



if($nomSend != "" && $prenomSend!="" && $dateSend != ""){
        //OK on lance l'assaut au serveur
        // Données à envoyer sous la forme d'un array
        // A part l'URL, et éventuellement les options, il n'y aurait que ce tableau à modifier
        $post = array(
            'Nom' => $nomPrenom,
            'DateNaissance' => $dateSend,
        );


     
        $data = http_build_query($post);
        $content = file_get_contents(
            'http://localhost:8888/infoAdherent.php',
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

        


        if($content.is_array() && (json_decode( $content, true)[0]['id'] != "D")){ // connexion réussie
            $arrayData = json_decode( $content, true);
            echo json_decode( $content, true)[0]['id'];
            //echo $content;
            //var_dump($arrayData);
            $id = $arrayData[0]['id'];
            $nom = $arrayData[0]['Nom'];
            $dateNaissance = $arrayData[0]['DateNaissance'];
            $classe = $arrayData[0]['Classe'];
            $statut = $arrayData[0]['Statut'];
            $pointsFidelite = $arrayData[0]['PointFidelite'];

            //Load de l'image loadImage.php
            $post = array(
                'idAdherent' => $id,
            );
            $data = http_build_query($post);
            $content = file_get_contents(
                'http://localhost:8888/loadImage.php',
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
                <link rel="stylesheet" href="styleFicheAdherent.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
                </head>

                <body>
                    <header>
                        <p><a href="homePageAdherent.php"><img src="source/logo.JPG" alt="logo de l'A2L" title="Se déconnecter"/></a></p>
                        <p>Fiche d'adhérent de l'A2L</p>
                    </header>
                    <section>
                        <article>
                            <h1 class="h1"> <?php echo $nom; ?></h1>
                            <p class="pdp"><?PHP echo '<img src="data:image/jpeg;base64,' . $imageData . '" class="logo">'; ?></p>
                            <p>Date de naissance : <strong> <?PHP echo $dateNaissance; ?> </strong> </p>
                            <p>Classe : <strong> <?PHP echo $classe; ?> </strong> </p>
                            <p>Statut: <strong> <?PHP echo $statut; ?> </strong> </p>
                            <p>Points de fidélité : <strong> <?PHP echo $pointsFidelite; ?> </strong> </p>
                            <p><?PHP echo '<img src="'.$QRcode.'">'; ?></p>
                            <p><a href="homePageAdherent.php" title="Retour à la page de connexion">Déconnexion</a></p>
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
        } else if($content == "\"Date de naissance incorrect\""){
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Informations incorrects</title>
                <link rel="stylesheet" href="style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="homePageAdherent.php" method ="POST", id="connexion">
                    <input type="hidden" value="Et dis voir ! La date de naissance c'est jour/mois/année ..." name="error">
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
                <link rel="stylesheet" href="style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="homePageAdherent.php" method ="POST", id="connexion">
                    <input type="hidden" value="Oups ... T'es sûre sûre de tout ce que tu m'as dit ? !" name="error">
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
		    <link rel="stylesheet" href="style.css"/>
		    <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
	</head>

	<body>
        <form action="homePageAdherent.php" method ="POST", id="connexion">
            <input type="hidden" value="Oups ... n'oublie pas de tout remplir !" name="error">
        </form>
        <script>
            document.forms["connexion"].submit();
        </script>
    </body>
    </html>
<?PHP } ?>