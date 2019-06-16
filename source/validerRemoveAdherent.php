<?PHP
session_start();
$id = $_POST['id'];
$nom = $_POST['Nom'];
$dateNaissance = $_POST['DateNaissance'];

$mdpAdmin = $_SESSION['MdpAdmin'];
$idAdmin = $_SESSION['id'];




if($nom !="" && $id != "" && $mdpAdmin != "" && $idAdmin != ""){
        //OK on lance l'assaut au serveur
        // Données à envoyer sous la forme d'un array
        // A part l'URL, et éventuellement les options, il n'y aurait que ce tableau à modifier

            $post = array(
                'id' => $id,
                'Nom' => $nom,
                'idAdmin' => $idAdmin,
                'MdpAdmin' => $mdpAdmin,
            );
        
        
         
            $data = http_build_query($post);
            $content = file_get_contents(
                'https://a2l-jl.com/api/removeAdherent.php',
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
        


    if($content == "\"Accès au serveur refusé\""){
        ?>
        <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Accès non autorisé</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
            </head>
    
            <body>
            <form action="https://a2l-jl.com/homePageAdmin.php" method ="POST", id="connexion">
                    
                </form>
                <script>
                    alert("Votre requète a été bloquée par le serveur ! On m'informe que vous n'avez pas les droits nécessaires. Verifiez que vous êtes bien super-admin et que vos informatiosn sont corrects. Vous allez être redirigé vers la page de connexion.");
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
        <?PHP
        
    } else if($content == "\"Mot de passe incorrect\""){ ?>
        <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Accès non autorisé</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
            </head>
    
            <body>
            <form action="https://a2l-jl.com/homePageAdmin.php" method ="POST", id="connexion">
                    
                </form>
                <script>
                    alert("Le serveur a bloqué votre requète ! Vos informatiosn semblent erronées. Vous allez être redirigé vers la page de connexion.");
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
    <?PHP } else if ($content == "\"success\""){ ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Success</title>
            <link rel="stylesheet" href="style.css"/>
            <link rel="shortcut icon" type="image/x-icon" href="logo.JPG"/>
            <meta http-equiv="refresh" content="0.1;URL=https://a2l-jl.com/listeAdherent.php">
            </head>
        </html>
    <?PHP } else { ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Echec dans la transmission des données</title>
            <link rel="stylesheet" href="source/style.css"/>
            <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
        </head>

        <body>
        <form action="https://a2l-jl.com/infoAboutAdherent.php?NomAdherent=<?PHP echo $nom; ?>&DateNaissance=<?PHP echo $dateNaissance; ?>" method ="POST", id="connexion">
                
            </form>
            <script>
                alert("Une erreur est survenue : Le serveur n'a pas répondu à votre requète. Il est fort probable que la suppression ait échoué. Veuillez rééssayer");
                document.forms["connexion"].submit();
            </script>
        </body>
        </html>
    <?PHP }

    
} else {
?>
<!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Echec dans la transmission des données</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
            </head>
    
            <body>
            <form action="https://a2l-jl.com/infoAboutAdherent.php?NomAdherent=<?PHP echo $nom; ?>&DateNaissance=<?PHP echo $dateNaissance; ?>" method ="POST", id="connexion">
                    
                </form>
                <script>
                    alert("Une erreur est survenue : Je n'ai pu identifier l'adhérent à supprimer :( OU ALORS, j'ai perdu vos données de connexion ... Veuillez réessayer et/ou vous re-connecter ");
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
<?PHP } ?>