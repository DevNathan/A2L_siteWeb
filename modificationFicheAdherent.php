<?php
session_start();
$nomAdmin = $_SESSION['NomAdmin'];
$prenom = $_SESSION['PrenomAdmin'];
$mdp = $_SESSION['MdpAdmin'];
$statutAdmin = $_SESSION['Statut'];

$nomPrenom = $nomAdmin . ' ' . $prenom;

$idAdherent = $_POST['idAdherent'];
$nomAdherent = $_POST['nomAdherent'];
$imageData = $_POST['imageData'];
$dateNaissanceAdherent = $_POST['dateNaissance'];
$classeAdherent = $_POST['classeAdherent'];
$statutAdherent = $_POST['statutAdherent'];

$error = $_POST['error'];

echo $error;



if($mdp != "" && $nomPrenom != ""){
            ?>
            <!DOCTYPE html>
            <html>
                <head>
                <meta charset="utf-8">
                <title>Fiche adhérent de l'A2L</title>
                <link rel="stylesheet" href="source/styleFicheAdherent.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
                </head>

                <body>
                
                    <header>
                        <div id="header">
                            <div class="elementHeader">
                                <form action="ficheAdmin.php" method ="POST", id="connexion">
                                    <input type="hidden" value="SESSION_STARTED" name="NomField">
                                </form>
                                    <p><a href="ficheAdmin.php"><img src="source/images/logo.JPG" alt="logo de l'A2L" title="Se déconnecter" class="logo"/></a></p>
                                    <p><a href="ficheAdmin.php" title="Accéder à ma fiche admin" onclick='javascript.document.forms["connexion"].submit();'>Fiche administrateur de l'A2L</a></p>
                                    
                            </div>
                            <div class="elementHeader">
                            <p><a href="listeAdherent.php" onclick='javascript.document.getElementById("afficheListe").submit()'><img src="source/liste.jpg" alt="Image d'une liste et un crayon" title="Acceder à la liste adhérent" class="liste"/></a></p>
                            <p><a href="listeAdherent.php" title="Acceder à la liste adhérent">Accéder à la liste des adhérents</a></p>
                            </div>
                        </div>
                    </header>
                    <section>
                        <article>
                        <h1 class="titreModification"><?PHP if($nomAdherent != ""){echo "Modifier les informations de " . $nomAdherent;}else{echo "Ajouter un nouvel adhérent";}?></h1>
                        <h2 class="error"><?PHP if($error != ""){echo "Une erreur est survenue. Vérifiez vos informations";}?></h2>
                            <form action="source/validerModificationsAdherent.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?PHP echo $idAdherent;?>"/>
                                <p>Nom prénom : <input type="text" value="<?PHP echo $nomAdherent?>" class="formulaire" name="nom" placeholder="!!!!! Nom + prénom !!!!!"/></p>
                                <p class="pdp"><?PHP echo '<img src="data:image/jpeg;base64,' . $imageData . '" class="logo">';?></p>
                                <p><?PHP if($error == ""){ echo "Selectionner une nouvelle photo d'identité :"; }else { echo "Il est possible, que suite à une erreur dans les données, la photo de profil ne charge pas. Cela ne veut pas dire pour autant qu'elle n'existe pas... Vous pouvez tout de même la modifier:";}?>
                                <input type="file" id="pdp" name="photo" id="photo" />
                                </p>
                                <p>Date de naissance : <input type="text" name="dateNaissance" value="<?PHP echo $dateNaissanceAdherent?>" class="formulaire" placeholder="!!!!! dd/mm/yyyy !!!!!"/></p>
                                <p>Classe : <input type="text" name="classe" value="<?PHP echo $classeAdherent?>" class="formulaire"/></p>
                                <?PHP if($statutAdherent != "Développeur"){ ?>
                                <p>Statut : <select name="statut" id="statut" class="formulaire">
                                    <option value="Adhérent" <?PHP if($statutAdherent == "Adhérent"){echo "selected";}?>>Adhérent</option>
                                    <option value="Membre du bureau" <?PHP if($statutAdherent == "Membre du bureau"){echo "selected";}?>>Membre du bureau</option>
                                    <option value="Super-admin" <?PHP if($statutAdherent == "Super-admin"){echo "selected";}?>>Super-admin</option>
                                </select> <a  onclick="helpClicked();" >?</a></p>
                                <?PHP } else if($statutAdherent == "Développeur"){ ?>
                                <p>Statut : <select name="statut" id="statut" class="formulaire">
                                    <option value="Développeur" <?PHP if($statutAdherent == "Développeur"){echo "selected";}?>>Développeur</option>
                                </select> <a onclick="helpClicked();" >?</a></p>
                                <?PHP } ?>
                                <script>
                                    function helpClicked(){
                                        alert("✔︎Adhérent: Ils ont accès à leur fiche adhérent personnelle et se connectent avec leur nom/prénom et date de naissance\n✔︎Membre du bureau : Ils ont accès aux fiches de tous les adhérents et peuvent scanner les QR code. Ils ne peuvent modifier que les points de fidélité. Ils se connectent avec un mot de passe.\n✔︎Super-admin: Vous êtes un super-admin. Vous disposez donc de tous les privilèges et vous pouvez modifier toutes les informations des adhérents.\n✔︎Developpeur: Ils disposent des mêmes droits que les super-admin, mais ne peuvent être déstitués.\n\nPour de plus amples informations consulter la page 'aide'")
                                    }
                                </script>
                                <p style="text-align: center;"><input type="submit" value="<?PHP if($nomAdherent != ""){echo "Valider";}else{echo"Créer";} ?>" class="validerFormulaire" /*onclick="document.forms['image'].sumbit()"*/></p>
                            </form>
                            <?PHP if($statutAdherent != "Développeur" && $nomAdherent != ""){?> 
                                    <div id="choixSuppression">
                                        <div class="choixSuppressionElement">
                                        <p id="deleteButton" class="deleteButton"><a id="cancel" style="color:green;" onclick="cancel();"></a></p>
                                        </div>
                                        <div class="choixSuppressionElement">
                                            <p id="deleteButton" class="deleteButton"><a onclick="removeButtonClicked();" id="removeButton">Supprimer cet adhérent</a></p>
                                        </div>
                                        <div class="choixSuppressionElement"> 
                                            <p id="deleteButton" class="deleteButton"><a id="remove" onclick="remove();"></a></p>
                                        </div>
                                    </div>
                                        
                                <?PHP } ?>
                                <form action="source/validerRemoveAdherent.php" method="post" id="removeSelected">
                                    <input type="hidden" name="id" value="<?PHP echo $idAdherent;?>"/>
                                    <input type="hidden" name="Nom" value="<?PHP echo $nomAdherent;?>"/>
                                    <input type="hidden" name="DateNaissance" value="<?PHP echo $dateNaissanceAdherent;?>"/>
                                </form>
                            <script>
                                function removeButtonClicked(){
                                    document.getElementById("cancel").textContent = "Annuler la suppression";
                                    document.getElementById("remove").textContent = "Supprimer définitivement";
                                    document.getElementById("removeButton").textContent = "";
                                }

                                function cancel(){
                                    document.getElementById("cancel").textContent = "";
                                    document.getElementById("remove").textContent = "";
                                    document.getElementById("removeButton").textContent = "Supprimer cet adhérent";
                                }

                                function remove(){
                                    document.getElementById("removeSelected").submit();
                                }
                            </script>
                                <p style="text-align:center;">
                                    <?PHP if($nomAdherent != ""){?>
                                        <a href="infoAboutAdherent.php?NomAdherent=<?PHP echo $nomAdherent; ?>&DateNaissance=<?PHP echo $dateNaissanceAdherent; ?>">Retour à la fiche adhérent</a>
                                    <?PHP } else {?>
                                        <a href="listeAdherent.php">Retour à liste adhérent</a>
                                    <?PHP } ?>
                                </p>
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
                                <p>Ce site web, et l'application on été developpés par <a href="http://nathanstchepinsky--nathans1.repl.co" title="Visiter le site du developpeur">Nathan</a></p>
				            </div>
			            </div>
		            </footer>
                </body>
            </html>
            <?PHP
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
            <input type="hidden" value="Oups ... On dirait bien que votre session a expiré" name="error">
        </form>
        <script>
            document.forms["connexion"].submit();
        </script>
    </body>
    </html>
<?PHP } ?>