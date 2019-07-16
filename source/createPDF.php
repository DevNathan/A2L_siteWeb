<?php
session_start();
$nom = $_SESSION['NomAdmin'];
$prenom = $_SESSION['PrenomAdmin'];
$mdp = $_SESSION['MdpAdmin'];

$nomPrenom = $nom . ' ' . $prenom;


$listeNomEncoded = $_POST['listeNom'];
$listeClasseEncoded = $_POST['listeClasse'];

$pathDefault = 'images/unknown.png';


$listeNom = json_decode($listeNomEncoded);
$listeClasse = json_decode($listeClasseEncoded);




function convertionString($word) {
    $reportSubtitle = stripslashes($word);
    $reportSubtitle = iconv('UTF-8', 'windows-1252', $reportSubtitle);
    return $reportSubtitle;
}


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
        $content = json_decode( $content, true);
            
        $count = 0;
            
        foreach($content as $i){
            
            if(in_array($i["Nom"], $listeNom)){
                $listeImage[$count] = $i['ImageData'];
                $dateNaissance[$count] = $i['DateNaissance'];
                $count ++;
            }
        }
    if($content.is_array()){ //L'admin est abilité acceder à cette page
        

        if(isset($listeNom) && isset($listeClasse)){
            
            require('Class/fpdf/fpdf.php'); // création du pdf
            
            $prenomTitre = convertionString("Prénom");
            $titre = convertionString("Carte adhérent");
            $pdf = new FPDF('L', 'mm', 'A4');
            
            $pdf->AddPage();
            for($i=0;$i<count($listeNom);$i++){
                if($listeImage[$i] == "none")
                    $decodedImg = "default";
                else
                    $decodedImg = base64_decode($listeImage[$i]);

                if ($decodedImg == NULL){
                    $decodedImg = "default";
                }
                
                
                if( $decodedImg!==false ){
                    //  Save image to a temporary location
                    if ($decodedImg == "default"){
                        $pathJPG = 'fichier/temporaire_pdf/nothing.png';
                        $pathPNG = 'fichier/temporaire_pdf/nothing.jpg';
                    }else {
                        $pathPNG = 'fichier/temporaire_pdf/image' . $i . '.png';
                        $pathJPG = 'fichier/temporaire_pdf/image' . $i . '.jpg';
                    }

                    
                    
                    $listeDate = explode("/", $dateNaissance[$i]);
                    $data = str_replace(' ', '%20', $listeNom[$i]) . "%23" . $dateNaissance[$i] . '%23' . ($listeDate[0] + $listeDate[1] + $listeDate[2]) % 10;
                    //echo $data;
                    $QRCode = file_get_contents('http://api.qrserver.com/v1/create-qr-code/?data='. $data .'&size=300x300');
                    
                    $QRCodePath = 'fichier/temporaire_pdf/Qr' . $i . '.png';
                    
                    if(file_put_contents($pathPNG,$decodedImg)!==false && file_put_contents($pathJPG,$decodedImg) !== false && file_put_contents($QRCodePath,$QRCode)!==false){
                        
                        if ($decodedImg == "default"){
                            $pathJPG = $pathDefault;
                            $pathPNG = $pathDefault;
                        }

                        
                        
                        switch($i%6){
                            case 0 : // 1
                                if ($i / 6 >=1){$pdf->AddPage();}
                                $nom = convertionString($listeNom[$i]);
                                $classe = convertionString($listeClasse[$i]);
                                $pdf->SetFont('Courier', 'B', '20');
                                $pdf->Image('images/fond_carte.png', 5, 5, 100);
                                
                                try {
                                    $pdf->Image($pathPNG, 11, 15, 20);
                                } catch (Throwable $e) {
                                    $pdf->Image($pathJPG, 11, 15, 20);
                                }
                                
                                //echo file_get_content($QRCode);
                                //echo $QRCode;
                                //echo "1";
                                $pdf->Image($QRCodePath, 87, 49,15);
                                //secho "0";
                                $pdf->Cell(26);
                                $pdf->Cell(40,15 ,"$titre");
                                $pdf->SetFont('Courier', 'B', '13');
                                $pdf->Ln(12);
                                $pdf->Cell(26);
                                $pdf->Cell(23,10 , "Nom $prenomTitre :");
                                $pdf->SetFont('Courier', '', '13');
                    
                                $pdf->Ln(5);
                                $pdf->Cell(26);
                                $pdf->Cell(40,10,"$nom");
                    
                                $pdf->Ln(7);
                                $pdf->Cell(26);
                                $pdf->SetFont('Courier', 'B', '13');
                                $pdf->Cell(25,10, "Classe :");
                                $pdf->SetFont('Courier', '', '13');
                                $pdf->Cell(20,10 , "$classe");
                            break;
                                
                            case 1: // 2
                                $nom = convertionString($listeNom[$i]);
                                $classe = convertionString($listeClasse[$i]);
                                $pdf->SetFont('Courier', 'B', '20');
                                $pdf->Image('images/fond_carte.png', 165, 5, 100);
                                try {
                                    $pdf->Image($pathPNG, 171, 15, 20);
                                } catch (Throwable $e) {
                                    $pdf->Image($pathJPG, 171, 15, 20);
                                }
                                $pdf->Image($QRCodePath, 247, 49,15);
                                $pdf->LN(-22);
                                $pdf->Cell(186);
                                $pdf->Cell(40,10 ,"$titre");
                                $pdf->SetFont('Courier', 'B', '13');
                                $pdf->Ln(12);
                                $pdf->Cell(186);
                                $pdf->Cell(23,10 , "Nom $prenomTitre :");
                                $pdf->SetFont('Courier', '', '13');
                    
                                $pdf->Ln(5);
                                $pdf->Cell(186);
                                $pdf->Cell(40,10,"$nom");
                    
                                $pdf->Ln(7);
                                $pdf->Cell(186);
                                $pdf->SetFont('Courier', 'B', '13');
                                $pdf->Cell(25,10, "Classe :");
                                $pdf->SetFont('Courier', '', '13');
                                $pdf->Cell(20,10 , "$classe");
                                break;
                            case 2: // 3
                                $nom = convertionString($listeNom[$i]);
                                $classe = convertionString($listeClasse[$i]);
                                $pdf->SetFont('Courier', 'B', '20');
                                $pdf->Image('images/fond_carte.png', 5, 65, 100);
                                try {
                                    $pdf->Image($pathPNG, 11, 75, 20);
                                } catch (Throwable $e) {
                                    $pdf->Image($pathJPG, 11, 75, 20);
                                }
                                $pdf->Image($QRCodePath, 87, 109,15);
                                $pdf->Cell(-205);
                                $pdf->Cell(40,83 ,"$titre");
                                $pdf->SetFont('Courier', 'B', '13');
                                $pdf->Ln(48);
                                $pdf->Cell(26);
                                $pdf->Cell(23,10 , "Nom $prenomTitre :");
                                $pdf->SetFont('Courier', '', '13');
                        
                                $pdf->Ln(5);
                                $pdf->Cell(26);
                                $pdf->Cell(40,10,"$nom");
                        
                                $pdf->Ln(7);
                                $pdf->Cell(26);
                                $pdf->SetFont('Courier', 'B', '13');
                                $pdf->Cell(25,10, "Classe :");
                                $pdf->SetFont('Courier', '', '13');
                                $pdf->Cell(20,10 , "$classe");
                                break;
                            case 3 : // 4
                                $nom = convertionString($listeNom[$i]);
                                $classe = convertionString($listeClasse[$i]);
                                $pdf->SetFont('Courier', 'B', '20');
                                $pdf->Image('images/fond_carte.png', 165, 65, 100);
                                try {
                                    $pdf->Image($pathPNG, 171, 75, 20);
                                } catch (Throwable $e) {
                                    $pdf->Image($pathJPG, 171, 75, 20);
                                }
                                $pdf->Image($QRCodePath, 247, 109,15);
                                $pdf->Cell(117);
                                $pdf->Cell(40,-37 ,"$titre");
                                $pdf->SetFont('Courier', 'B', '13');
                                $pdf->Ln(-13);
                                $pdf->Cell(188);
                                $pdf->Cell(23,10 , "Nom $prenomTitre :");
                                $pdf->SetFont('Courier', '', '13');
                        
                                $pdf->Ln(5);
                                $pdf->Cell(188);
                                $pdf->Cell(40,10,"$nom");
                        
                                $pdf->Ln(7);
                                $pdf->Cell(188);
                                $pdf->SetFont('Courier', 'B', '13');
                                $pdf->Cell(25,10, "Classe :");
                                $pdf->SetFont('Courier', '', '13');
                                $pdf->Cell(20,10 , "$classe");
                                break;
                            case 4 : // 5
                                $nom = convertionString($listeNom[$i]);
                                $classe = convertionString($listeClasse[$i]);
                                $pdf->SetFont('Courier', 'B', '20');
                                $pdf->Image('images/fond_carte.png', 5, 130, 100);
                                try {
                                    $pdf->Image($pathPNG, 11, 140, 20);
                                } catch (Throwable $e) {
                                    $pdf->Image($pathJPG, 11, 140, 20);
                                }
                                $pdf->Image($QRCodePath, 87, 174,15);
                                $pdf->Cell(-207);
                                $pdf->Cell(40,94 ,"$titre");
                                $pdf->SetFont('Courier', 'B', '13');
                                $pdf->Ln(52);
                                $pdf->Cell(26);
                                $pdf->Cell(23,10 , "Nom $prenomTitre :");
                                $pdf->SetFont('Courier', '', '13');
                        
                                $pdf->Ln(5);
                                $pdf->Cell(26);
                                $pdf->Cell(40,10,"$nom");
                        
                                $pdf->Ln(7);
                                $pdf->Cell(26);
                                $pdf->SetFont('Courier', 'B', '13');
                                $pdf->Cell(25,10, "Classe :");
                                $pdf->SetFont('Courier', '', '13');
                                $pdf->Cell(20,10 , "$classe");
                                break;
        
                            case 5 : // 6
                                $nom = convertionString($listeNom[$i]);
                                $classe = convertionString($listeClasse[$i]);
                                $pdf->SetFont('Courier', 'B', '20');
                                $pdf->Image('images/fond_carte.png', 165, 130, 100);
                                try {
                                    $pdf->Image($pathPNG, 171, 140, 20);
                                } catch (Throwable $e) {
                                    $pdf->Image($pathJPG, 171, 140, 20);
                                }
                                $pdf->Image($QRCodePath, 247, 174,15);
                                $pdf->Cell(117);
                                $pdf->Cell(40,-34 ,"$titre");
                                $pdf->SetFont('Courier', 'B', '13');
                                $pdf->Ln(-11);
                                $pdf->Cell(188);
                                $pdf->Cell(23,10 , "Nom $prenomTitre :");
                                $pdf->SetFont('Courier', '', '13');

                                $pdf->Ln(5);
                                $pdf->Cell(188);
                                $pdf->Cell(40,10,"$nom");
                        
                                $pdf->Ln(7);
                                $pdf->Cell(188);
                                $pdf->SetFont('Courier', 'B', '13');
                                $pdf->Cell(25,10, "Classe :");
                                $pdf->SetFont('Courier', '', '13');
                                $pdf->Cell(20,10 , "$classe");
                                break; 
                            default :
                                $XAdded = 0;
                                $YAdded = 0;
                                break;
                        }
                        if ($pathJPG != $pathDefault){
                            unlink($pathPNG);
                            unlink($pathJPG);
                        } else {
                            unlink('fichier/temporaire_pdf/nothing.png');
                            unlink('fichier/temporaire_pdf/nothing.jpg');
                        }
                        //unlink('fichier/temporaire_pdf/Qr.png');
                        
                    } else {
                        echo "L'image n'a pas pu être stockée sur le serveur";
                    }
                    
                    } else {
                        echo "L'image n'a pas pu être décodée";
                    }
                }
                $pdf->Output();
            
            
            
            
        } else { // pas de données
            
            
            $titreErreur = convertionString("Aucune donnée n'a pu être reçue !");
            $firstDescription = convertionString("Cette erreur provient d'une erreur dans la transmission des données. Vérifiez que vous disposez bien des droits nécessaires pour effectuer cette action. Vous devez être super-admin. Vérifiez de plus que le site vous aillant redirigé ici est bien le site officiel de l'A2L. Pour cela, l'url suivant doit être exacte https://a2l-jl.com (il est possible que la mention https soit absente dans se cas cliquer dans la bar de lien pour verifier. Il est aussi possible que '.com' soit suivit d'un slash /.). Si vous pensez que cette dernière URL a été usurpée, ou que le site se fait passer pour l'A2L de Jean Lurçat, signalez immédiatement cette erreur au lien suivant : https://A2L-JL.com/pageAide.php (Pour plus de sécruité, copiez et collez le lien directement.)");
            $secondDescription = convertionString("Si cette erreur persiste et que vous êtes certains de vos données, contactez le développeur dans la section 'Aide'");
            
            require('Class/fpdf/fpdf.php');
            $pdf = new FPDF('L', 'mm', 'A4');
            $pdf->AddPage();
            $pdf->SetFont('Courier', 'B', '50');
            $pdf->SetTextColor(247, 8, 0);
            $pdf->MultiCell(270,10, "Une erreur est survenue : ",0, "C");
            $pdf->Ln(20);
            $pdf->SetFont('Courier', 'B', '40');
            
            
            $pdf->MultiCell(270,10, "$titreErreur");
            $pdf->Ln(20);
            $pdf->SetFont('Courier', '', '15');
            $pdf->SetFillColor(247, 8, 0);
            
            $pdf->MultiCell(250,13, "$firstDescription");
            $pdf->Ln(5);
            $pdf->MultiCell(200,13, "$secondDescription");
            $pdf->Output();


            
        }
        
    } else if ($content == "Accès au serveur refusé" || $content == "Mdp incorrect"){ // Il n'a pas les autorisations nécessaires
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
                    <input type="hidden" value="Cette section est réservée au super-admin ! Vous avez été redirigé(e) et déconnecté(e) par sécurité" name="error">
                </form>
                <script>
                    document.forms["connexion"].submit();
                </script>
            </body>
            </html>
            <?PHP
    } else {
    }
} else { // pas de mot de passe
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


