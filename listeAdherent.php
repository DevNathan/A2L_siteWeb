<?php
session_start();
$nom = $_SESSION['NomAdmin'];
$prenom = $_SESSION['PrenomAdmin'];
$mdp = $_SESSION['MdpAdmin'];
$recherche = $_GET['recherche'];

$nomPrenom = $nom . ' ' . $prenom;


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
            'http://a2l-jl.com/api/returnAllData.php',
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
            $count = 0;
            
            if($recherche == ""){
                foreach($arrayData as $i){
               
                    $nomArray[$count] = $i['Nom'];
                    //echo $i['Nom'];
                    //echo $count;
                    //echo $nom[1];
                    $dateNaissance[$count] = $i['DateNaissance'];
                    $classe[$count] = $i['Classe'];
                    $statut[$count] = $i['Statut'];
                    $pointsFidelite[$count] = $i['PointFidelite'];
                    $count ++;
                   }
            } else {
                foreach($arrayData as $i){
                    if(strpos($i['Nom'], $recherche) !== false || strpos($i['Statut'], $recherche) !== false || strpos($i['Classe'], $recherche) !== false){
                        $nomArray[$count] = $i['Nom'];
                        $dateNaissance[$count] = $i['DateNaissance'];
                        $classe[$count] = $i['Classe'];
                        $statut[$count] = $i['Statut'];
                        $pointsFidelite[$count] = $i['PointFidelite'];
                        $count ++;
                    }
                    
                    
                   }
                   
            }
            

            ?>
            <!DOCTYPE html>
            <html>
                <head>
                <meta charset="utf-8">
                <title>Liste adhérents</title>
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
                                    <p><a href="ficheAdmin.php"><img src="source/logo.JPG" alt="logo de l'A2L" title="Se déconnecter" class="logo"/></a></p>
                                    <p><a href="ficheAdmin.php" title="Accéder à ma fiche admin" onclick='javascript.document.forms["connexion"].submit();'>Fiche administrateur de l'A2L</a></p>
                                    <script>
                                        function postData(){
                                            
                                        }
                                    </script>
                            </div>
                            <div class="elementHeader">
                            <p><img src="source/liste.jpg" alt="Image d'une liste et un crayon" title="Acceder à la liste adhérent" class="liste"/></p>
                            <p>● Accéder à la liste des adhérents</p>
                            </div>
                        </div>
                    </header>
                    <section>
                        <article>
                            <div id="topBar">
                                <div class="topBarElement">
                                    <form method="get" action="listeAdherent.php">
                                        <p>Rechercher :<input type="text" name="recherche" placeholder="Nom, prenom, classe, statut ..." value="<?PHP echo $recherche; ?>" class="searchBar"/><input value="Rechercher" type="submit"/></p>
                                    </form>
                                </div>
                                <div class="topBarElement">
                                    <p><a href="modificationFicheAdherent.php">Ajouter un nouvel adhérent</a></p>
                                </div>
                            </div>
                            <ul>
                            <?php
                                for($count = 0; $count<count($nomArray);$count++){
                                    
                                    ?>
                                    
                                        <p><li>
                                        <div id = "li">
                                            <div class="liElement">
                                                <a href="infoAboutAdherent.php?NomAdherent=<?PHP echo $nomArray[$count];?>&DateNaissance=<?PHP echo $dateNaissance[$count]?>" class="lien" onclick="" id="Nom"><?PHP echo $nomArray[$count];?></a>
                                                
                                                    
                                            </div>
                                            <div class="liElement">
                                                <strong class="classe"> <?PHP echo $classe[$count]?></strong>
                                            </div>
                                            <div class="liElement">
                                                <span class="statut"><?PHP echo $statut[$count]; ?></span>
                                            </div>
                                        </div>
                                        </li></p>

                                        
                                    <?PHP
                                }
                            ?>
                            </ul>
                            <p><a href="homePageAdmin.php" title="Retour à la page de connexion">Déconnexion</a></p>
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
            echo $content;
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
                    <input type="hidden" value="Oups ... On dirait bien que tu n'es pas autorisé a faire tout ça .... " name="error">
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
            <input type="hidden" value="Oups ! Votre session a expiré ..." name="error">
        </form>
        <script>
            document.forms["connexion"].submit();
        </script>
    </body>
    </html>
<?PHP } ?>