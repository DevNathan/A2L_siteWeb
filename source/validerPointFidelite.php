<?PHP 
session_start();
$id = $_SESSION['id'];
$mdpSend = $_SESSION['MdpAdmin'];

$URL = $_POST['url'];
$pointFidelite = $_POST['PointFidelite'];
$idAdherent = $_POST['idAdherent'];



if($id !="" && $mdpSend != ""){
    if(is_numeric($pointFidelite)){
        //OK on lance l'assaut au serveur
        // Données à envoyer sous la forme d'un array
        // A part l'URL, et éventuellement les options, il n'y aurait que ce tableau à modifier
        $post = array(
        'idAdmin' => $id,
        'mdpAdmin' => $mdpSend,
        'id' => $idAdherent,
        'PointFidelite' => $pointFidelite,
    );


 
    $data = http_build_query($post);
    $content = file_get_contents(
        'https://a2l-jl.com/api/stockNewPointFidelite.php',
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

    if($content == "Accès au serveur refusé"){
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
            <form action="../homePageAdmin.php" method ="POST", id="connexion">
                <input type="hidden" value="Oups.... L'accès au serveur a été refuse" name="error">
            </form>
            <script>
                document.forms["connexion"].submit();
            </script>
        </body>
        </html>
        <?PHP
    } else { // RÉUSSITE : 
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Success</title>
            <link rel="stylesheet" href="style.css"/>
            <link rel="shortcut icon" type="image/x-icon" href="logo.JPG"/>
            <meta http-equiv="refresh" content="0.1;URL=<?PHP echo $URL;?>">
            
        </head>
        </html>
        <?PHP
        echo "Success";
    }


    } else { // n'est pas un nombre ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Informations incorrects</title>
            <link rel="stylesheet" href="style.css"/>
            <link rel="shortcut icon" type="image/x-icon" href="logo.JPG"/>
            
        </head>
        <body>
            <p class="h1error">Veuillez entrer un nombre. L'opération a échouée</p>
            <a href="<?PHP echo $URL;?>">Retour</a>
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
        <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
</head>

<body>
    <form action="../homePageAdmin.php" method ="POST", id="connexion">
        <input type="hidden" value="Oups ... on dirait que votre session a expiré" name="error">
    </form>
    <script>
        document.forms["connexion"].submit();
    </script>
</body>
</html>
<?PHP } ?>