<?php
session_start();
$nomSend = htmlspecialchars($_POST["NomField"]);
$prenomSend = htmlspecialchars($_POST["PrenomField"]);
$mdpSend = hash('sha256', $_POST["MdpField"]);


if ($nomSend == ""){
    $nomSend = htmlspecialchars($_SESSION['NomAdmin']);
    $prenomSend = htmlspecialchars($_SESSION['PrenomAdmin']);
    $mdpSend = $_SESSION['MdpAdmin'];
}

$nomPrenom = $nomSend . ' ' . $prenomSend;


 sleep(1);



if($nomSend != "" && $prenomSend!="" && $mdpSend != ""){
        //OK on lance l'assaut au serveur
        // Données à envoyer sous la forme d'un array
        // A part l'URL, et éventuellement les options, il n'y aurait que ce tableau à modifier
        $post = array(
            'Nom' => $nomPrenom,
            'Mdp' => $mdpSend,
        );


     
        $data = http_build_query($post);
        $content = file_get_contents(
            'https://a2l-jl.com/api/infoAdmin.php',
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

        $arrayData = json_decode( $content, true);
        if(is_numeric($arrayData[0]['id'])) { // connexion réussie

            $_SESSION['NomAdmin'] = $nomSend;
            $_SESSION['PrenomAdmin'] = $prenomSend;
            $_SESSION['MdpAdmin'] = $mdpSend;
            //echo $content;
            //var_dump($arrayData);
            $id = $arrayData[0]['id'];
            $nom = $arrayData[0]['Nom'];
            $dateNaissance = $arrayData[0]['DateNaissance'];
            $classe = $arrayData[0]['Classe'];
            $statut = $arrayData[0]['Statut'];
            $pointsFidelite = $arrayData[0]['PointFidelite'];

            $_SESSION['id'] = $id;
            $_SESSION['Statut'] = $statut;


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
                <title>Fiche admin</title>
                <link rel="stylesheet" href="source/styleFicheAdherent.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
                </head>

                <body>
                <?PHP require("source/Class/EtatSite/etat_site.php");
                $etatSite = new EtatSite();
                ?>
                <div id="maintenance" style="background:<?PHP echo $etatSite->getColor(); ?>;"><h1><?PHP echo $etatSite->getMessage(); ?></h1></div>                    <header>
                        <div id="header">
                            <div class="elementHeader">
                                <p><a href="#"><img src="source/images/logo.JPG" alt="logo de l'A2L" title="Se déconnecter" class="logo"/></a></p>
                                <p>● Fiche administrateur de l'A2L</p>
                            </div>
                            <div class="elementHeader">
                            <p><a href="listeAdherent.php" onclick='javascript.document.getElementById("afficheListe").submit()'><img src="source/images/liste.jpg" alt="Image d'une liste et un crayon" title="Acceder à la liste adhérent" class="liste"/></a></p>
                            <p><a href="listeAdherent.php" title="Acceder à la liste adhérent">Accéder à la liste des adhérents</a></p>
                            </div>
                        </div>
                    </header>
                    <section>
                        <article>
                            <h1 class="h1"> <?php echo $nom; ?></h1>
                            <?PHP if($imageData != "none"){ ?>
                                <p class="pdp"><?PHP echo '<img src="data:image/jpeg;base64,' . $imageData . '" class="logo">'; ?></p>
                                <p>Changer de photo de profil :</p>
                            <?PHP } else { ?>
                                <p>Pas de photo ...... Choisis en une toi même !!</p>
                            <?PHP } ?>
                            <form action="source/uploadImage.php" method="POST" id="image" enctype="multipart/form-data">
                                    
                                <input type="file" id="pdp" name="photo" id="photo"/>
                                <input type="hidden" name="id" value="<?PHP echo $id;?>"/>
                                <input type="hidden" name="url" value="https://a2l-jl.com/ficheAdherent.php"/>
                                <input type="submit" value="Valider !"/>
                            </form>
                            
                            <p>Date de naissance : <strong> <?PHP echo $dateNaissance; ?> </strong> </p>
                            <p>Classe : <strong> <?PHP echo $classe; ?> </strong> </p>
                            <p>Statut: <strong> <?PHP echo $statut; ?> </strong> </p>
                            <p>Points de fidélité : <strong> <?PHP echo $pointsFidelite; ?> </strong> </p>
                            <p><?PHP echo '<img src="'.$QRcode.'">'; ?></p>
                            <p><a href="homePageAdmin.php" title="Retour à la page de connexion" onclick='<?PHP /*session_destroy();*/?>'>Déconnexion</a></p>
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
            <?PHP
        } else if($content == "\"Mdp incorrect\""){
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Informations incorrects</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
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
            echo $content;
        ?>
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Informations incorrects</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
            </head>
    
            <body>
                <form action="homePageAdmin.php" method ="POST", id="connexion">
                    <input type="hidden" value="Oups ... Il faut être membre du bureau pour se connecter ici ? ;)" name="error">
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
		    <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
	</head>

	<body>
        <form action="homePageAdmin.php" method ="POST", id="connexion">
            <input type="hidden" value="Oups ... n'oublie pas de tout remplir !" name="error">
        </form>
        <script>
            document.forms["connexion"].submit();
        </script>
    </body>
    </html>
<?PHP } ?>