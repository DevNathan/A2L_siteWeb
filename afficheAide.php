<?PHP
$titre = $_GET['titre'];
$section = $_GET['section'];
$listeTitreSecurite = ["Qui a accès à mes informations ?", "Comment sont stockés mes informations ?", "Comment sont stockés les mots de passe ?", "Est-ce que 'Open Source' signifie que tout le monde a accès à mes données ?", "[Avancé] Comment l'accès au serveur est-il géré ?"];
$listeTitreAboutUsing = ["A quoi sert le QR code ?", "Qui sont les membres du bureau ?", "Pourquoi me demande-ton ma date de naissance ?", "[Admin] Quels sont mes privilèges ?", "[Admin] Comment devenir admin ?", "[Admin] Quels sont les critères requis pour ajouter un adhérent", "[Admin] Qu'est ce que le code temporaire ?", "[Admin] Comment créer ou modifier un mot de passe ?", "[Admin] Que se passe-t-il lorsqu'un admin perd son grade ?"];
$listeTitreError = ["Impossible de me connecter car mon mot de passe est incorrect", "Impossible de me connecter car l'accès est refusé", "Impossible de me connecter : Le serveur ne répond pas", "Impossible de me connecter au cause d'une erreur inconnue"];
$listeTitreSite = ["Que siginfie open source ?", "Comment participer au projet ?", "Comment le serveur fonctionne-t-il ?", "Information de développement"];
$descriptionAboutSecurity = ["Seuls vous et les membres du bureau de l'A2L ont accès à vos informations. Elles ne sont partagées avec aucun autre service et les seuls moyens de récuperer vos données se font avec votre date de naissance ou le mot de passe des admin. Ainsi seuls les application officielles peuvent gérer vos données.<br /> <br />Aucune entorse à cette règle de sera jamais tolérée par l'association comme par les développeurs.", "Lorsque qu'un membre du bureau crée votre fiche adhérent, toutes les données sont stockées sur le serveur de l'A2L.<br /> <br />Elles ne peuvent être modifiées qu'avec la connexion au serveur avec un mot de passe spécifique aux applications et avec les mots de passes des membres du bureau. Les méthodes de transmission de données sont sécurisées et capables de parer un grand nombre d'attaque.", "Les mots de passe des admin sont stockés sur le serveur sous la forme d'un hash.<br /><br />Ok mais c'est quoi ? La méthode de hashage est une méthode VITALE pour la conservation de mots de passes. Elle consiste à 'faire rentrer votre mot de passe dans un machine' qui va en sortir une chaine de caractère complétement imbuvable et avec laquelle il est strcitement impossible de rentrouver la chaine de caractère originale. Lorsque que vous vous connecter, on hash donc votre mot de passe et on regarde si le hash correspond au hash déjà enregsitré.<br /><br />Dans le cas des applications dès l'instant où vous appuyez sur 'se connecter' votre mot de passe est immédiatement hashé par l'application avec une méthode de dite forte. Ainsi à aucun moment l'application ne possède le mot de passe en clair. Ensuite, lors de sa connexion au serveur, il fournit donc son hash à la base de donnée. Elle va le hasher une 2e fois pour le stocker. Cette fois-ci, nous utilision du BCrypt, qui est la méthode de hashage la plus sûr de nos jours, avec un taux de sécurité proche de 100%. Ainsi le hash stocké ne correspond pas au hash de l'application. Cela renforce grandement la sécurité des mots de passes. Cette dernière est pleinement fonctionnelle et sûre.<br /><br />En résumé vos mots de passes et vos informations sont 100% protégés de bout en bout. Autrement dit je peux vous assurer que nous sommes loin d'un scandale digne de facebook et ses mots de passes en clair ;);)", "Open source de l'anglais \"rivière ouverte\" (non je rigole 'source ouvrte') signifie que le code source de l'application et du serveur (qui gère la gestion des données) est connu, consultable et modifiable par tous. Cela signifie que tout le monde peut comprendre comment le programme tourne. EN REVANCHE, la base de donnée et les codes confidentiels de connexion à celle-ci sont strictement privés et ne sont pas dévoilés au grand public.<br /><br />Par exemple, on sait comment fonctionne la poste. Tous les jours, à tel heure, un camion passe et dépose dans notre boite au lettre des colis/lettres ou alors tous les jours les 'boites aux lettres jaunes' sont relevées pour transmettre les lettres postées. Ce fonctionnement est connu de tous. Date, horaire, lieu et fonction. Cependant cela ne vous permet de pas de voir le contenu des lettres. Un projet open source c'est la même chose. On en voit le fonctionnement mais pas les données qui transitent.<br /><br />Ainsi le gros avantage est que le projet peut être repris pour être amélioré !! Et j'encourage les petits génies de l'informatique qui liront ceci à vite reprendre l'application pour l'améliorer encore et encore. Et en plus de cela, il est très facile de découvrir d'eventuels failles qui pourront être corrigées très rapidement.", "Attention : cette partie necessite quelque connaissances en développement. Rien ne t'empêche de lire ces lignes.<br /><br />L'accèes au serveur est géré par deux authentifications. La première est la clé de connexion possédée par les applications. Elle est stockée dans un fichier privé qui n'est pas partagé. Cette clé permet donc la connexion à la base MySQL afin de lancer la requète. Elles permettent donc de s'assurer que seuls les applications peuvent utiliser l'API du serveur. Enfin si ces informatiosn sont corrects, 99% des requètes nécessitent le mot de passe de l'admin. Si celui est correct et UNIQUEMENT dans cette configuration, l'accès au serveur sera permis (le 1% concerne la connexion des ahdérents qui se fait avec la date de naissance).<br /> <br />Ainsi, la connexion se base sur 2 critères essentiels. Consultez le ReadMe du repository pour plus d'informations sur la sécurité du serveur et la gestion des attaques"];
$descriptionAboutUsing = ["Le QR code est généré par l'application elle même et contient 2 informations afin de savoir à qui ce QR code appartient sans se tromper. Il contient donc votre date de naissance et votre nom/prénom. Bien entendu aucune autre information n'est communiquée car il peut être dechiffré par tout le monde.<br /><br />Les petits curieux auront remarqué qu'il possède une petite particularité essentielle qui permet de valider son authenticité ;)", "Les membres du bureau de l'A2L sont nommés chaque année lors du conseil d'administration. Ce sont eux qui sont à l'origine de nombreux projets (celui-ci notamment) et votent les mesures à prendre pour la suite ! Je vous encourage vivement à aller vous présenter en fin d'année ! Vous ne le regretterez pas.", "C'est une excellente question à laquelle il y a 2 réponses. La première est purement technique. Même si cela est évité au maximum, avec un nom et une date de naissance on évite les doublons et garantissons identité. Le 2e point est d'ordre confidentiel. En effet, même si c'est une information pas très compliqué à trouver, cela évite que d'autre puisse accéder à votre fiche par la simple connaissance de votre nom et prénom ...", "En tant que membre du bureau, vous disposez de droits adminisatrateurs. Ainsi seuls ces derniers peuvent scanner le QR code des adhérents, accéder à la liste complète de l'A2L et augmenter les points de fidélités. :)<br /><br />Certains admin disposent de droits supplémentaires et peuvent donc ajouter des adhérents à la base de donnée et modifier ses informations. Ils sont joliment appelés 'super-admin'. Ils ne concernent que les memebres permanants du CA qui necessitent des droits particuliers et qui sont de grandes confiances. En limiter le nombre permet de garantir la sécurité des données. Ce statut est tout de moins vitale et doit être tout de même donné à certain élève pour éviter toute anarchie ;)", "Pour devenir admin il faut simplement devenir membre du bureau ! N'oubliez pas de rappeler aux super-admin de vous grader sur l'application si vous rentrez dans le bureau de l'A2L.", "Pour ajouter un adhérent il faut être super-admin tout simplement. Aller dans la liste des adhérents et vous trouverez un bouton + en haut à droite.", "Pour modifier ou vous créer un mot de passe en tant qu'administrateur vous devez vous munir d'un code temporaire confidentiel. Il est généré par n'importe quel admin directement sur votre fiche adhérent. Il se compose d'un nombre à 4 chiffres produit aléatoirement. Pour des raisons de sécurité les mots de passes ne peuvent être enregistrés qu'avec l'accord d'un admin. C'est le rôle du code confidentiel.<br /><br />Lorsque l'on génère un code, celui-ci est immédiatement stocké et hashé sur le serveur en BCrypt (la méthode de hashage la plus sûr de nos jours). Il devient donc actif instantanément. En générer un nouveau annule le précédent. De même qu'une fois utilisé il devient inactif.<br /><br />ATTENTION : Pour des raisons de sécurité une fois que vous quittez la page de l'adhérent, vous ne pourrez plus jamais visualiser le code. Il n'en reste pas moins actif. Alors notez le précieusement ;)", "Si vous n'avez pas encore de mot de passe ou que vous l'avez oublié vous pouvez vous créer à tout moment un nouveau mot de passe. Pour cela rien de plus simple il vous suffit d'aller sur la page de connexion 'Admin' et de d'aller sur 'Partir à la recherche de mon mot de passe'. Il faudra alors renseigner votre nom et prénom suivi de votre code temporaire confidentiel qui devra être généré par un admin via votre fiche adhérent.Vous pourrez ensuite vous créer un nouveau mot de passe.", "Lorsqu'un administrateur effectue une action qui necessite une connexion au serveur, ce dernier vérifie que le demandeur possède encore le bon mot de passe ainsi qu'il est encore autorisé par son grade d'effectuer l'action. Cela signifie qu'à l'instant où vous validez le nouveau statut de l'admin, son statut est immédiatement changé et à partir de ce moment l'ancien admin recevra un message d'erreur lui indiquant que 'l'accès au serveur lui est refusé'. Et donc il ne pourra plus effectuer aucune action.<br /><br />En cas d'abus, pas de panique, une simple modification et il deviendra totalement inoffensif ;)<br /><br />Note : Dégrader un adhérent ne supprime pas son mot de passe. Ce dernier est seulement désactivé. Si l'adhérent est regradé à nouveau, son mot de passe restera inchangé et actif"];
$descriptionError = ["Je crois que pour cette erreur le message est assez clair ... Si vous avez perdu votre mot de passe n'hésitez pas à le réinitialiser en cas de perte.<br /><br />Si cette erreur persiste prévenez le developpeur via un signalement de bug.", "Cette erreur est survenue lors de la connexion de l'application au serveur. Cela peut provenir d'anciennes informations stockées sur le téléphone. Pour récupérer vos dernières informations officielles 'Actualiser [vos] infos' dans les réglages. Vous pourrez ainsi déterminer quel était le problème.", "Pas besoin de google traduction pour celle ci : ça veut tout simplement dire que la requète envoyée au serveur est trop longue. Verifiez votre connexion internet. Si cette erreur persiste signalez la au développeur dans les réglages ;)", "Alors pour cette dernière je vous avoue que ça va être dur de vous aider précisément j'en ai bien peur. Quelques conseils cependant : relancez l'application, actualisez vos informations et réessayez. Si cette erreur persiste dans le temps signalez la situation PRÉCISE au developpeur ! Merci ;)"];
$descriptionSite = ["Open source signifie sue le code source est disponible à n'importe qui, n'importe quand. Si ce détail vous inquiète veuillez consulter l'aide 'Est-ce qu'open source signifie sue tout le monde à accès à mes informations ?'. Dans le principe, le code est stocké sur github. Vous pouvez trouver les liens dans les réglages via \"participer au projet\". On peut y trouver le code sources des deux applications et du serveur. Bien entendu toute contribution est la bienvenue, tout rapport de sécurité, d'idée ou n'importe quel commentaire ;) Alors si vous vous y connaissez un petit peu, venez jeter un coup d'oeil et ENJOY ! ", "L'application et tout le projet qui gravite autour ne doit pas en resté là ! Elle doit absolument être améliorée, corrigée et enrichie constamment. Alors chaque idée est bonne, chaque talent est important, chaque participation est énorme ! Alors n'hésitez surtout pas et proposez ! Si l'occasion vous en donne l'envie, devenez le développeur intra-lycée et de travaillez avec les autres développeurs ! Proposez vos idées via les réglages et la section 'Signaler'", "Le serveur (codé en PHP/MySQL) ne fonctionne qu'avec les applications officielles. Il a pour role de renvoyer a l'application toutes les informations dont elle a besoin. Tout est donc traité avant l'envoi et à la réception. Enfin, 99% des fonctions ne sont accessibles qu'avec le nom et mot de passe d'un admin. Consultez le ReadMe du repository pour plus d'informations sur la sécurité du serveur et la gestion des attaques", "Développeur(s) : Nathan Stchepinsky<br /><br />Language(s) : Swift 5<br /><br />IDE : Xcode<br /><br />Nombre de fichier: 54<br /><br />Nombre de ligne (dont commentaires) : 3760 (736)<br /><br />Repository ? Oui [Github] (voir dans réglages>participer au projet)<br /><br />Version : 1.0<br /><br />Date de création du projet :08/01/2019 par Nathan Stchepinsky<br /><br />Date publication : Non publiée"];

switch($section){
    case "securite":
        $arrayTitre = $listeTitreSecurite;
        $arrayDescription = $descriptionAboutSecurity;
        $sourceImage = "source/images/empreinteDigitale.png";
        break;

    case "erreur":
        $arrayTitre = $listeTitreError;
        $arrayDescription = $descriptionError;
        $sourceImage = "source/images/croix.png";
        break;

    case "a_propos":
        $arrayTitre = $listeTitreSite;
        $arrayDescription = $descriptionSite;
        $sourceImage = "source/images/atom.png";
        break;

    case "utilisation":
        $arrayTitre = $listeTitreAboutUsing;
        $arrayDescription = $descriptionAboutUsing;
        $sourceImage = "source/images/ordinateur.png";
        break;

    default :
        break;

}

$titreAide = "Aucune aide séléctionnée";
$descriptionAide = "Vous voyez, même pour la page d'aide il y a une aide ... <br/><br/> Retourner sur le page d'aide pour séléctionner une aide. Si vous en venez et que vous voyez ce message alors, c'est que cette aide comporte une erreur. Veuillez donc la signaler au près du développeur ! <br/> Merci !";

for($count = 0; $count<count($arrayTitre);$count++){
    if(strpos($arrayTitre[$count], $titre) !== false){
        $titreAide = $arrayTitre[$count];
        $descriptionAide = $arrayDescription[$count];
    }
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Page d'aide</title>
		<link rel="stylesheet" href="source/stylePageAide.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="source/images/logo.JPG"/>
	</head>

	<body>
		<header>
            <p><a href="pageAide.php"><img src="source/images/logo.JPG" alt="logo de l'A2L" title="Se déconnecter" class="logo"/></a></p>
            <p><a href="pageAide.php">Retour à la page d'aide</a></p>
            <p><a href="index.php"> < Retour</a></p>
        </header>
		<section>
			<article>
                <h1 id="titreAide"><?PHP echo $titreAide; ?></h1>
                <p id="imageAide"><img src="<?PHP echo $sourceImage; ?>" alt="image en adéquation avec le type d'aide demandé"/></p>
                <p id="descriptionAide"><?PHP echo $descriptionAide;?></p>
			</article>
			
		</section>
		<footer>
			<div id="footer">
				<div class="elementFooter">
					<p><a href=mailto:nathanstchepinsky@gmail.com title="Signaler un bug"> Signaler un bug</a></p>
				</div>
				<div class="elementFooter">
					<p><a href="#" title="Aide">Un peu d'aide ?</a></p>
				</div>
				<div class="elementFooter">
					<p>Ce site web, et l'application on été developpés par <a href="http://nathanstchepinsky--nathans1.repl.co" title="Visiter le site du developpeur">Nathan</a></p>
				</div>
			</div>
		</footer>
	</body>
</html>


