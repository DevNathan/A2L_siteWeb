<?PHP 
$nom = $_POST['Nom'];
$mdp = hash('sha256',$_POST['Mdp']);
$mdpConfirm = hash('sha256', $_POST['MdpConfirm']);
$codeTemporaire = $_POST['CodeTemporaire'];



if($nom !="" && $nom != "" && $codeTemporaire != ""){
    if($mdp == $mdpConfirm){
        //OK on lance l'assaut au serveur
        // Données à envoyer sous la forme d'un array
        // A part l'URL, et éventuellement les options, il n'y aurait que ce tableau à modifier
        $post = array(
        'Nom' => $nom,
        'Mdp' => $mdp,
        'CodeTemporaire' => $codeTemporaire,
    );


 
    $data = http_build_query($post);
    $content = file_get_contents(
        'https://a2l-jl.com/api/stockNewMdp.php',
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
                <title>Informations incorrects</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="reinitialiseMotDePasse.php" method ="POST", id="connexion">
                    <input type="hidden" value="L'accès au serveur vous a été refusé" name="error">
                </form>
                <script>
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
        <?PHP
    } else if($content == "Success"){ // RÉUSSITE : 
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Success</title>
            <link rel="stylesheet" href="style.css"/>
            <link rel="shortcut icon" type="image/x-icon" href="logo.JPG"/>
            <meta http-equiv="refresh" content="2;URL=https://a2l-jl.com/homePageAdmin.php">
            
        </head>
        <body style="backgroundColor=green;">
        <body>
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
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="reinitialiseMotDePasse.php" method ="POST", id="connexion">
                    <input type="hidden" value="La connexion au serveur est impossible" name="error">
                </form>
                <script>
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
        <?PHP
    }


    } else { // n'est pas un nombre ?>
        <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Informations incorrects</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="reinitialiseMotDePasse.php" method ="POST", id="connexion">
                    <input type="hidden" value="Vos mots de passes ne correspondent pas ......" name="error">
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
                <title>Informations incorrects</title>
                <link rel="stylesheet" href="source/style.css"/>
                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>
            </head>
    
            <body>
                <form action="reinitialiseMotDePasse.php" method ="POST", id="connexion">
                    <input type="hidden" value="Une erreur est survenue" name="error">
                </form>
                <script>
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
<?PHP } ?>