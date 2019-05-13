<?PHP 
$nom = $_POST['Nom'];
$prenom = $_POST['Prenom'];
$dateNaissance = $_POST['DateNaissance'];

//var_dump($_FILES['photo']);
if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0)
{
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['photo']['size'] <= 1000000)
        {
            // Testons si l'extension est autorisée
            
            $infosfichier = pathinfo($_FILES['photo']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'jpeg', 'png', 'JPG');
            if (in_array($extension_upload, $extensions_autorisees))
            {
                /*$resized = $_FILES['photo'];
                $size = max(imagesx($resized), imagesy($resized)); //Make the square so the thumbnail fits in it
                $thumbNail = imagecreate($size, $size);  //Square.
                imagecopy($thumbNail, 
                ($size-imagesx($resized))/2,   //Put the image in the middle of the square
                ($size-imagesy($resized))/2, 
                    0,
                    0,
                imagesx($resized),
                imagesy($resized)  
                );*/
                //Créer un dossier 'fichiers/1/'
                mkdir('fichier/1/', 0777, true);
 
  //Créer un identifiant difficile à deviner
                $nom = md5(uniqid(rand(), true));
                $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
                $extension_upload = strtolower(  substr(  strrchr($_FILES['photo']['name'], '.')  ,1)  );
                if ( in_array($extension_upload,$extensions_valides) ) echo "Extension correcte";
                $nom = "https://a2l-jl.com/dataLocal";
                $resultat = move_uploaded_file($_FILES['photo']['tmp_name'],$nom);
                if ($resultat) {echo "Transfert réussi"; } else { echo "ptn"; }
                //echo " \n \n";
                //var_dump($_FILES['photo']);
                ?>
                <!DOCTYPE html>
                <html>
	                <head>
		                <meta charset="utf-8">
		                <title>A2L connexion admin</title>
		                <link rel="stylesheet" href="source/style.css"/>
		                <link rel="shortcut icon" type="image/x-icon" href="source/logo.JPG"/>

	                </head>

	                <body>
                        <p><img src="<?PHP echo basename($_FILES['photo']['name']);?>"/></p>
                    </body>
                    
                </html>
                <?PHP
                
            }
        }
}
?>