<?php
$nom = $_POST['NomAdmin'];
$prenom = $_POST['PrenomAdmin'];
$mdp = $_POST['MdpHashed'];

$nomPrenom = $nom . ' ' . $prenom;

echo $nomPrenom;
echo $mdp;

if($mdp != "" && $nomPrenom != ""){
     //OK on lance l'assaut au serveur
        // Données à envoyer sous la forme d'un array
        // A part l'URL, et éventuellement les options, il n'y aurait que ce tableau à modifier
        $post = array(
            'Nom' => $nomPrenom,
            'Mdp' => $mdp,
        );


     
        $data = http_build_query($post);
        $content = file_get_contents(
            'http://localhost:8888/returnAllData.php',
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
            //echo $content;
            //var_dump($arrayData);
            for($i = 0; $i < $arrayData.count; $i++) {
                $id[$i] = $arrayData[$i]['id'];
                $nom[$i] = $arrayData[$i]['Nom'];
                $dateNaissance[$i] = $arrayData[$i]['DateNaissance'];
                $classe[$i] = $arrayData[$i]['Classe'];
                $statut[$i] = $arrayData[$i]['Statut'];
                $pointsFidelite[$i] = $arrayData[$i]['PointFidelite'];
            }

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
                        <div id="header">
                            <div class="elementHeader">
                                <form id="afficheFiche" method="POST" action="ficheAdmin.php">
                                    <input type="hidden" name="">
                                </form>
                                    <p><a href="homePageAdmin.php"><img src="source/logo.JPG" alt="logo de l'A2L" title="Se déconnecter" class="logo"/></a></p>
                                    <p><a href="infoAdmin.php" title="Accéder à ma fiche admin" action>Fiche administrateur de l'A2L</a></p>
                                
                            </div>
                            <div class="elementHeader">
                            <p><a href="listeAdherent.php"><img src="source/liste.jpg" alt="Image d'une liste et un crayon" title="Acceder à la liste adhérent" class="liste"/></a></p>
                                <p>● Liste des adhérents</p>
                            </div>
                        </div>
                    </header>
                    <section>
                        <article>
                            <ol>
                            <?php
                                for($i = 0;$i < $nom.count ; $i++){
                                    ?>
                                        <li><a href=""><?PHP echo $nom[$i];?></a></li>
                                    <?PHP
                                }
                            ?>
                            </ol>
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
                <link rel="stylesheet" href="style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="homePageAdmin.php" method ="POST", id="connexion">
                    <input type="hidden" value="Oups.... Mot de passe incorrect" name="error">
                </form>
                <script>
                    //document.forms["connexion"].submit();
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
                <link rel="stylesheet" href="style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="homePageAdmin.php" method ="POST", id="connexion">
                    <input type="hidden" value="Oups ... Il faut être membre du bureau pour se connecter ici ? ;)" name="error">
                </form>
                <script>
                    //document.forms["connexion"].submit();
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
		    <link rel="stylesheet" href="style.css"/>
		    <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
	</head>

	<body>
        <form action="homePageAdmin.php" method ="POST", id="connexion">
            <input type="hidden" value="Oups ... n'oublie pas de tout remplir !" name="error">
        </form>
        <script>
            //document.forms["connexion"].submit();
        </script>
    </body>
    </html>
<?PHP } ?>