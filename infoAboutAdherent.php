<?php
session_start();
$nomAdmin = $_SESSION['NomAdmin'];
$prenom = $_SESSION['PrenomAdmin'];
$mdp = $_SESSION['MdpAdmin'];
$statutAdmin = $_SESSION['Statut'];

$nomPrenom = $nomAdmin . ' ' . $prenom;

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
            $haveCodeTemporaire = $arrayData[0]['HaveCodeTemporaire?'];


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
                <title>Fiche adhérent de l'A2L</title>
                <link rel="stylesheet" href="source/styleFicheAdherent.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="soure/images/logo.JPG"/>
                </head>

                <body>
                <?PHP require("source/Class/EtatSite/etat_site.php");
                $etatSite = new EtatSite();
                ?>
                <div id="maintenance" style="background:<?PHP echo $etatSite->getColor(); ?>;"><h1><?PHP echo $etatSite->getMessage(); ?></h1></div>                    <header>
                        <div id="header">
                            <div class="elementHeader">
                                <form action="ficheAdmin.php" method ="POST", id="connexion">
                                    <input type="hidden" value="SESSION_STARTED" name="NomField">
                                </form>
                                    <p><a href="ficheAdmin.php"><img src="source/images/logo.JPG" alt="logo de l'A2L" title="Se déconnecter" class="logo"/></a></p>
                                    <p><a href="ficheAdmin.php" title="Accéder à ma fiche admin" onclick='javascript.document.forms["connexion"].submit();'>Fiche administrateur de l'A2L</a></p>
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
                        
                        <h2 class="modification"><a href="#" onclick='document.forms["modificationClicked"].submit();'>Modifier les informations</a></h2>
                            <p class="pdp"><?PHP echo '<img src="data:image/jpeg;base64,' . $imageData . '" class="logo">'; ?></p>
                            <p>Date de naissance : <strong> <?PHP echo $dateNaissance; ?> </strong> </p>
                            <p>Classe : <strong> <?PHP echo $classe; ?> </strong> </p>
                            <p>Statut: <strong> <?PHP echo $statut; ?> </strong> </p>
                            <form action="source/validerPointFidelite.php" method="post"><!--Sert a valider le code temporaire-->
                                <p>Points de fidélité : <input type="number" min="0" max="10" step="1" value="<?PHP echo $pointsFidelite; ?>" class="pointFidelite" name="PointFidelite"/> <input type="submit" value="Valider" class="pointFidelite"/></p>
                                <input type="hidden" name="url" value="https://a2l-jl.com/infoAboutAdherent.php?NomAdherent=<?PHP echo $nomAdherent;?>&DateNaissance=<?PHP echo $dateNaissanceAdherent; ?>"/>
                                <input type="hidden" name="idAdherent" value="<?PHP echo $id;?>"/>
                            </form>

                            <form action="modificationFicheAdherent.php" method="post" id="modificationClicked"><!--Sert a valider les modifications-->
                                <input type="hidden" name="idAdherent" value="<?PHP echo $id?>"/>
                                <input type="hidden" name="nomAdherent" value="<?PHP echo $nomAdherent; ?>"/>
                                <input type="hidden" name="imageData" value="<?PHP echo $imageData; ?>"/>
                                <input type="hidden" name="dateNaissance" value="<?PHP echo $dateNaissance; ?>"/>
                                <input type="hidden" name="classeAdherent" value="<?PHP echo $classe; ?>"/>
                                <input type="hidden" name="statutAdherent" value="<?PHP echo $statut; ?>"/>
                            </form>
                            <p><?PHP echo '<img src="'.$QRcode.'">'; ?></p>
                            <?PHP
                                if($statut != "Adhérent" && ($statutAdmin == "Développeur" || $statutAdmin == "Super-admin")){
                                    
                                    if($haveCodeTemporaire == "false" && $_POST['CodeTemporaire'] == ""){
                                        ?>
                                            <form id="New" action="source/validerCodeTemporaire.php" method="post">
                                                <input type="hidden" name="actionAsked" value="new"/>
                                                <input type="hidden" name="id" value="<?PHP echo $id;?>"/>
                                                <input type="hidden" name="url" value="../infoAboutAdherent.php?NomAdherent=<?PHP echo $nomAdherent;?>&DateNaissance=<?PHP echo $dateNaissanceAdherent; ?>"/>
                                            </form>
                                            <div id="codeButton">
                                            <div class="codeButtonElement">
                                                <p><a href="#" onclick='document.forms["New"].submit()'>Générer un code temporaire</a></p>
                                            </div>
                                            
                                            
                                        <?PHP
                                    } else if($haveCodeTemporaire == "true" && $_POST['CodeTemporaire'] == ""){ ?>
                                    
                                        <form id="Suppr" action="source/validerCodeTemporaire.php" method="post">
                                            <input type="hidden" name="actionAsked" value="suppr"/>
                                            <input type="hidden" name="id" value="<?PHP echo $id;?>"/>
                                            <input type="hidden" name="url" value="../infoAboutAdherent.php?NomAdherent=<?PHP echo $nomAdherent;?>&DateNaissance=<?PHP echo $dateNaissanceAdherent; ?>"/>
                                        </form>
                                        <form id="SupprAndReplace" action="source/validerCodeTemporaire.php" method="post">
                                            <input type="hidden" name="actionAsked" value="supprAndReplace"/>
                                            <input type="hidden" name="id" value="<?PHP echo $id;?>"/>
                                            <input type="hidden" name="url" value="../infoAboutAdherent.php?NomAdherent=<?PHP echo $nomAdherent;?>&DateNaissance=<?PHP echo $dateNaissanceAdherent; ?>"/>
                                        </form>
                                        <p><a href="#" onclick='document.forms["Suppr"].submit()'>Supprimer le code temporaire déjà actif</a></p>
                                        <p><a href="#" onclick='document.forms["SupprAndReplace"].submit()'>Supprimer et générer un nouveau code temporaire</a></p>
                                    
                                    <?PHP } else if ($haveCodeTemporaire == "true" && $_POST['CodeTemporaire'] != ""){ ?>
                                    
                                        <p> Code temporaire : <strong><?PHP echo $_POST['CodeTemporaire'];?></strong></p>
                                        
                                        
                                        <form id="Suppr" action="source/validerCodeTemporaire.php" method="post">
                                            <input type="hidden" name="actionAsked" value="suppr"/>
                                            <input type="hidden" name="id" value="<?PHP echo $id;?>"/>
                                            <input type="hidden" name="url" value="../infoAboutAdherent.php?NomAdherent=<?PHP echo $nomAdherent;?>&DateNaissance=<?PHP echo $dateNaissanceAdherent; ?>"/>
                                        </form>
                                        <form id="SupprAndReplace" action="source/validerCodeTemporaire.php" method="post">
                                            <input type="hidden" name="actionAsked" value="supprAndReplace"/>
                                            <input type="hidden" name="id" value="<?PHP echo $id;?>"/>
                                            <input type="hidden" name="url" value="../infoAboutAdherent.php?NomAdherent=<?PHP echo $nomAdherent;?>&DateNaissance=<?PHP echo $dateNaissanceAdherent; ?>"/>
                                        </form>
                                        <p><a href="#" onclick='document.forms["Suppr"].submit()'>Supprimer le code temporaire déjà actif</a></p>
                                        <p><a href="#" onclick='document.forms["SupprAndReplace"].submit()'>Supprimer et générer un nouveau code temporaire</a></p>
                                    <?PHP }?>
                                    <div class="codeButtonElement">
                                                <p><a href="#" class="info" onclick="alert('Ce code est généré aléatoirement et doit être transmis à l\'admin concerné afin qu\'il puisse créer un mot de passe ou le réinitiliser\n\n⚠︎⚠︎⚠︎ATTENTION⚠︎⚠︎⚠︎\nGénérer un code suffit à le rendre valide. En générer un nouveau désactive le précédent. Ce code restera valide jusqu\'à son utilisation s\'il n\'est pas re-généré.\nUne fois que vous quitterez cette page vous ne pourrez plus voir le code. Il faudra donc en créer un nouveau. Même si vous n\'avez plus accès à son contenu le code restera valide quand vous aurez quitté la page')">Bah oui mais c'est quoi ?</a></p>
                                            </div>
                                        </div>
                                <?PHP }
                            ?>
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
		    <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
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