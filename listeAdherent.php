<?php
session_start();
$nom = $_SESSION['NomAdmin'];
$prenom = $_SESSION['PrenomAdmin'];
$mdp = $_SESSION['MdpAdmin'];
$recherche = $_GET['recherche'];
$mode = $_GET['mode']; // rien = normal, selectionCarte = sélectionner des adhérents pour imprimer des cartes 

$nomPrenom = $nom . ' ' . $prenom;
$path = 'source/images/avatar.png';
$data = file_get_contents($path);
$imageDefaultEncoded = base64_encode($data);//image par défaut codé en base 64

$path = 'source/images/unknown.png';
$data = file_get_contents($path);
$imageDefaultPDF = base64_encode($data);





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
                    $idArray = $i["id"];
                    $nomArray[$count] = $i['Nom'];
                    //echo $i['Nom'];
                    //echo $count;
                    //echo $nom[1];
                    $dateNaissance[$count] = $i['DateNaissance'];
                    $classe[$count] = $i['Classe'];
                    $statut[$count] = $i['Statut'];
                    $pointsFidelite[$count] = $i['PointFidelite'];
                    $imageEncoded[$count] = $i['ImageData'];
                    $count ++;
                   }
            } else {
                foreach($arrayData as $i){
                    if(strpos($i['Nom'], $recherche) !== false || strpos($i['Statut'], $recherche) !== false || strpos($i['Classe'], $recherche) !== false){
                        $idArray[$count] = $i["id"];
                        $nomArray[$count] = $i['Nom'];
                        $dateNaissance[$count] = $i['DateNaissance'];
                        $classe[$count] = $i['Classe'];
                        $statut[$count] = $i['Statut'];
                        $pointsFidelite[$count] = $i['PointFidelite'];
                        $imageEncoded[$count] = $i['ImageData'];
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
                <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
                </head>

                <script>
                    //Déclaration des différents tableaux : 
                    var listeNom = [];
                    var listeClasse = [];
                    
                    var listeCheckboxId = [];
                    var nbrTotalAdherentShown = <?PHP echo count($nomArray);?>
                </script>
                <body>
                <?PHP require("source/Class/EtatSite/etat_site.php");
                $etatSite = new EtatSite();
                ?>
                <div id="maintenance" style="background:<?PHP echo $etatSite->getColor(); ?>;"><h1><?PHP echo $etatSite->getMessage(); ?></h1></div>                <?PHP if($mode == "selectionCarte") {?>
                        <div id="sendButton" onClick="validerSelected()"><p class="sendButton">Valider</p></div>
                        <div id="backButton" onClick="annulerSelected()"><p class="backButton">Annuler tout</p></div>

                        <form method="get" action="listeAdherent.php" id="annuler" ></form>
                        <form method="post" action="source/createPDF.php" id="valider" target="_blank">
                            <input type="hidden" id="nomTransmitted" name="listeNom" value=""/>
                            <input type="hidden" id="classeTransmitted" name="listeClasse" value=""/>
                        </form>
                        <script>
                            function validerSelected(){
                                if (window.listeCheckboxId.length == 0){
                                    document.getElementById("sendButton").style["background-color"] = "gray";
                                } else {
                                    
                                    document.getElementById("nomTransmitted").value = JSON.stringify(window.listeNom);
                                    document.getElementById("classeTransmitted").value = JSON.stringify(window.listeClasse);
                                    document.forms["valider"].submit();
                                    
                                }
                            }

                            function annulerSelected(){
                                document.forms["annuler"].submit();
                            }
                        </script>
                <?PHP } ?>
                    <header>
                        <div id="header">
                        <div class="elementHeader">
                                <form action="ficheAdmin.php" method ="POST", id="connexion">
                                    <input type="hidden" value="SESSION_STARTED" name="NomField">
                                </form>
                                    <p><a href="ficheAdmin.php"><img src="source/images/logo.JPG" alt="logo de l'A2L" title="Se déconnecter" class="logo"/></a></p>
                                    <p><a href="ficheAdmin.php" title="Accéder à ma fiche admin" onclick='javascript.document.forms["connexion"].submit();'>Fiche administrateur de l'A2L</a></p>
                                    <script>
                                        function postData(){
                                            
                                        }
                                    </script>
                            </div>
                            <div class="elementHeader">
                            <p><img src="source/images/liste.jpg" alt="Image d'une liste et un crayon" title="Acceder à la liste adhérent" class="liste"/></p>
                            <p>● Accéder à la liste des adhérents</p>
                            </div>
                        </div>
                    </header>
                    <section>
                        <article>
                        <?PHP if($mode == "selectionCarte"){ ?>

                            
                            <h2>Sélectionnez les ahdérents dont vous voulez imprimer la carte adhérent. Plus la sélection est grande, plus le temps de création du pdf sera long ... un peu de patience mes chères ;)</h2>
                            <div id="topBar">
                                <div class="topBarElement">
                                    <form method="get" action="listeAdherent.php">
                                        <p>Rechercher :<input type="text" name="recherche" placeholder="Nom, prenom, classe, statut ..." value="<?PHP echo $recherche; ?>" class="searchBar"/><input type="hidden" value="selectionCarte" name="mode"><input value="Rechercher" type="submit"/></p>
                                    </form>
                                </div>
                                <div class="topBarElement">
                                    <p><a onClick="addAll()" class="AddButton" id="addAllButton">Je veux tout le monde !</a></p>
                                </div>
                            </div>
                            
                            <div id = "checkbox">
                            <?php
                                for($count = 0; $count<count($nomArray);$count++){
                                    if($imageEncoded[$count] == "none"){ 
                                        $image = $imageDefaultEncoded;
                                    }else{ 
                                        $image = $imageEncoded[$count];
                                    }
                                    ?>
                                    <div class="checkboxElement" id="checkbox<?PHP echo $count; ?>" onClick="adherentAdded('<?PHP echo $count; ?>')">
                                        
                                    <p><strong id="nom<?PHP echo $count; ?>"><?PHP echo $nomArray[$count];?></strong>
                                            <br/><img src=<?PHP echo "source/displayImage.php?id=" . $idArray[$count]; ?> class="pdpForAll"/>
                                        <br/><strong class="classe"> <?PHP echo $classe[$count]?><br/></strong><span class="statut"><?PHP echo $statut[$count]; ?></span></p>
                                        <input type="hidden" id="classe<?PHP echo $count; ?>" value="<?PHP echo $classe[$count]; ?>"/>
                                    </div>
                                    <?PHP
                                }?>
                                <script>
                                    function adherentAdded(count){
                                        //alert(window.listeCheckboxId.includes("checkbox" + count));
                                        if (window.listeCheckboxId.includes("checkbox" + count)){ // déjà coché
                                            document.getElementById("checkbox" + count).style["background"]="rgba(255, 255, 255, 1)";
                                            for(var i=0;i < window.listeCheckboxId.length;i++){
                                                if(window.listeCheckboxId[i] == ("checkbox" + count)){
                                                    window.listeCheckboxId.splice(i,1);
                                                    window.listeNom.splice(i,1);
                                                    window.listeClasse.splice(i,1);
                                                    i--;
                                                }
                                            }
                                            if(window.listeCheckboxId.length == 0){
                                                //Bouton ajouté activé : 
                                                document.getElementById("sendButton").style["background"]="gray";
                                            }
                                        } else {
                                            //Bouton ajouté activé :
                                            
                                            document.getElementById("sendButton").style["background"]="rgb(10, 179, 4)";
                                            document.getElementById("checkbox" + count).style["background"]="rgba(72, 255, 0, 0.5)";
                                            window.listeCheckboxId.push("checkbox" + count);
                                            window.listeNom.push(document.getElementById("nom" + count).innerHTML);
                                            window.listeClasse.push(document.getElementById("classe" + count).value);
                                            
                                        }
                                        
                                    }

                                    function addAll(){
                                        
                                        if(document.getElementById("addAllButton").innerHTML == "Je veux tout le monde !"){
                                            document.getElementById("addAllButton").innerHTML = "Chargement ....";
                                            //alert(document.getElementById("nom400").innerHTML);
                                            for(var i=0;i < window.nbrTotalAdherentShown;i++){
                                                window.listeCheckboxId.push("checkbox" + i);
                                                window.listeNom.push(document.getElementById("nom" + i).innerHTML);
                                                window.listeClasse.push(document.getElementById("classe" + i).value);
                                                document.getElementById("checkbox" + i).style["background"]="rgba(72, 255, 0, 0.5)"; 
                                                
                                            }
                                            
                                            document.getElementById("addAllButton").innerHTML = "Non finalement je veux plus personne ...";
                                            document.getElementById("sendButton").style["background-color"]="rgb(10, 179, 4)";
                                            
                                            
                                        } else {
                                            for(var i=0;i < window.nbrTotalAdherentShown;i++){
                                                document.getElementById("checkbox" + i).style["background"]="rgba(255, 255, 255, 1)";
                                            }
                                            document.getElementById("addAllButton").innerHTML = "Je veux tout le monde !";
                                            window.listeCheckBox = [];
                                            window.listeNom = [];
                                            window.listeDateNaissance = [];
                                            document.getElementById("sendButton").style["background-color"]="gray";
                                        }
                                        
                                    }
                                </script>
                                </div> <?PHP
                            /*mode sélection carte fin*/ } else { // mode normal début
                        ?>
                            <div id="topBar">
                                <div class="topBarElement">
                                    <form method="get" action="listeAdherent.php">
                                        <p>Rechercher :<input type="text" name="recherche" placeholder="Nom, prenom, classe, statut ..." value="<?PHP echo $recherche; ?>" class="searchBar"/><input value="Rechercher" type="submit"/></p>
                                    </form>
                                </div>
                                <div class="topBarElement">
                                    <p><a href="modificationFicheAdherent.php" class="AddButton">Ajouter un nouvel adhérent</a></p>
                                </div>
                            </div>
                            <div id="topBarSecond">
                            <div class="topBarSecondElement">
                                    <p><a href="listeAdherent.php?mode=selectionCarte" class="AddButton" title="Permet de générer un PDF des différentes cartes adhérents des élèves sélectionnés. Mieux vaut aller morceau par morceau ... ;)">Générer des cartes adhérents</a></p>
                                </div>
                                <div class="topBarSecondElement">
                                    <p><a href="listeAdherent.php?mode=selectionCarte" class="AddButton"></a></p>
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
                            <?PHP } ?> <!-- mode normal fin-->
                            <p><a href="homePageAdmin.php" title="Retour à la page de connexion">Déconnexion</a></p>
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
		    <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
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