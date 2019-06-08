<?PHP
session_start();
$id = $_POST['id'];
$nom = $_POST['nom'];
$photo = $_POST["photo"];
$dateNaissance = $_POST['dateNaissance'];
$classe = $_POST['classe'];
$statut = $_POST['statut'];

$mdpAdmin = $_SESSION['MdpAdmin'];
$idAdmin = $_SESSION['id'];





if($nom !="" && $dateNaissance != "" && $classe != "" && $statut != "" && $mdpAdmin != "" && $idAdmin != ""){
        //OK on lance l'assaut au serveur
        // Données à envoyer sous la forme d'un array
        // A part l'URL, et éventuellement les options, il n'y aurait que ce tableau à modifier
        $post = array(
        'id' => $id,
        'Nom' => $nom,
        'DateNaissance' => $dateNaissance,
        'Statut' => $statut,
        'Classe' => $classe,
        'idAdmin' => $idAdmin,
        'MdpAdmin' => $mdpAdmin,
    );


 
    $data = http_build_query($post);
    $content = file_get_contents(
        'https://a2l-jl.com/api/updateAllInfo.php',
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
    $content = json_decode( $content, true);


    if($content == "\"Accès au serveur refusé\""){
        ?>
        <<!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Informations incorrectes</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="../homePageAdmin.php" method ="POST", id="connexion">
                    <input type="hidden" value="Vous ne disposez pas des droits nécessaires pour effectuer cette action" name="error">
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
            <title>Success</title>
            <link rel="stylesheet" href="style.css"/>
            <link rel="shortcut icon" type="image/x-icon" href="logo.JPG"/>
            <meta http-equiv="refresh" content="0.1;URL=https://a2l-jl.com/infoAboutAdherent.php?NomAdherent=<?PHP echo $nom; ?>&DateNaissance=<?PHP echo $dateNaissance; ?>">
        </head>
        </html>
        <?PHP
    }

    
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
            <form action="../modificationFicheAdherent.php" method ="POST", id="connexion">
                    <input type="hidden" value="unknown" name="error">
                    <input type="hidden" value="<?PHP echo $id;?>" name="idAdherent">
                    <input type="hidden" value="<?PHP echo $nom;?>" name="nomAdherent">
                    <input type="hidden" value="<?PHP echo $photo;?>" name="imageData">
                    <input type="hidden" value="<?PHP echo $dateNaissance;?>" name="dateNaissance">
                    <input type="hidden" value="<?PHP echo $classe;?>" name="classeAdherent">
                    <input type="hidden" value="<?PHP echo $statut;?>" name="statutAdherent">
                </form>
                <script>
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
<?PHP } ?>