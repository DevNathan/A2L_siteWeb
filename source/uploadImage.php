<?PHP 
$id = $_POST['id'];
$url = $_POST['url'];

//resize and crop image by center
function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80){
    $imgsize = getimagesize($source_file);
    $width = $imgsize[0];
    $height = $imgsize[1];
    $mime = $imgsize['mime'];
 
    switch($mime){
        case 'image/gif':
            $image_create = "imagecreatefromgif";
            $image = "imagegif";
            break;
 
        case 'image/png':
            $image_create = "imagecreatefrompng";
            $image = "imagepng";
            $quality = 7;
            break;
 
        case 'image/jpeg':
            $image_create = "imagecreatefromjpeg";
            $image = "imagejpeg";
            $quality = 80;
            break;
 
        default:
            return false;
            break;
    }
     
    $dst_img = imagecreatetruecolor($max_width, $max_height);
    $src_img = $image_create($source_file);
     
    $width_new = $height * $max_width / $max_height;
    $height_new = $width * $max_height / $max_width;
    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
    if($width_new > $width){
        //cut point by height
        $h_point = (($height - $height_new) / 2);
        //copy image
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
    }else{
        //cut point by width
        $w_point = (($width - $width_new) / 2);
        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
    }
     
    $image($dst_img, $dst_dir, $quality);
 
    if($dst_img)imagedestroy($dst_img);
    if($src_img)imagedestroy($src_img);
}
//usage example


//var_dump($_FILES['photo']);
if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0)
{
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['photo']['size'] <= 5000000)
        {
            // Testons si l'extension est autorisée
            
            $infosfichier = pathinfo($_FILES['photo']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'jpeg', 'png', 'JPG');
            if (in_array($extension_upload, $extensions_autorisees))
            {
                
                //Créer un dossier 'fichiers/1/'
                $fileNewName = uniqid('',true).".".$extension_upload;
                $filedestination = 'uploads/'.$fileNewName;
                move_uploaded_file($_FILES['photo']['tmp_name'], $filedestination);
                $imageSize = getimagesize($filedestination);
                resize_crop_image(300, 300, $filedestination, $filedestination);
                $base64 = base64_encode(file_get_contents($filedestination)); 
                //On envoie l'image dans le serveur 
                $post = array(
                    'id' => $id,
                    'data' => $base64,
                );
        
        
             
                $data = http_build_query($post);
                $content = file_get_contents(
                    'https://a2l-jl.com/api/uploadImage.php',
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
                unlink($filedestination);
                ?>
                <!DOCTYPE html>
                <html>
	                <head>
		                <meta charset="utf-8">
		                <title>Upload en cours ...</title>
		                <link rel="stylesheet" href="source/style.css"/>
                        <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
                        <meta http-equiv="refresh" content="0.1;URL=<?PHP echo $url;?>">
                    </head>
                </html><?PHP
                
            } else {
                ?>
                <!DOCTYPE html>
                <html>
	                <head>
		                <meta charset="utf-8">
		                <title>Aucune image sélectionnée</title>
		                <link rel="stylesheet" href="source/style.css"/>
                        <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
                        <meta http-equiv="refresh" content="0.1;URL=<?PHP echo $url;?>">
                    </head>
                    <body>
                        <script>
                            alert("Veuillez saisir une image ... C'est plus pratique pour une photo d'identité !")
                        </script>
                    </body>
                </html><?PHP
            }
        } else {
            ?>
                <!DOCTYPE html>
                <html>
	                <head>
		                <meta charset="utf-8">
		                <title>Image trop lourde</title>
		                <link rel="stylesheet" href="source/style.css"/>
                        <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
                        <meta http-equiv="refresh" content="0.1;URL=<?PHP echo $url;?>">
                    </head>
                    <body>
                        <script>
                            alert("Aïe ! Ce fichier est beaucoup trop lourd pour mon pauvre dos !!")
                        </script>
                    </body>
                </html><?PHP
        }
} else {
    ?>
                <!DOCTYPE html>
                <html>
	                <head>
		                <meta charset="utf-8">
		                <title>Une erreur est survenue</title>
		                <link rel="stylesheet" href="source/style.css"/>
                        <link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
                        <meta http-equiv="refresh" content="0.1;URL=<?PHP echo $url;?>">
                    </head>
                    <body>
                        <script>
                            alert("Oups ... une erreur est survenue")
                        </script>
                    </body>
                </html><?PHP
}
?>