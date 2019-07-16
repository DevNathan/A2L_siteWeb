<?PHP
Class EtatSite {
    function getMessage(){
        //$message ="Votre développeur préféré continue de construire ce site ... Quelques bugs peuvent donc encore se cacher, veuillez m'en excuser";
        //$message ="Votre développeur préféré est en plein travail de Une maintenance sur ce site. Veuillez excuser, les potentiels bugs et l'ajout progressif de fonctionnalités";
        return "Votre développeur préféré est en plein travail de maintenance sur ce site. Veuillez excuser, les potentiels bugs et l'ajout progressif de fonctionnalités";        ;
    }

    function getColor(){
        return "rgba(247, 0,0, 0.7)"; // red=rgba(247, 0, 0,0.5), orange =rgba(240, 145, 4, 0.5)
    }
}

?>