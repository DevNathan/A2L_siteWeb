[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](http://www.gnu.org/licenses/gpl-3.0) ![Codacy Security Scan](https://github.com/DevNathan/A2L_siteWeb/workflows/Codacy%20Security%20Scan/badge.svg) [![Website a2l-jl.com](https://img.shields.io/website-up-down-green-red/https/naereen.github.io.svg)](https://a2l-jl.com)
# Disclaimer : Fermeture du site web

Faute d'utilité, le projet entier comprenant la programmation web, serveur et iOS sera arrêté à compter du 09 juin 2021 à 00h00. L'entièreté du projet reste disponible sur ce GitHub.

Une copie entière de la base de donnée sera effectuée avant la fermture et sera sauvegardée et chiffrée en local

Je tiens ainsi à assurer que ce projet m'a beaucoup apporté et qu'il a été réalisé avec grand plaisir.

Toute idée ou transformation de ce projet par un developpeur interne au lycée peut être à l'origine d'un relancement du projet et une remise en disponibilité du site web afin de satfisfaire un objectif précis.

Je reste à la disposition de l'A2L, ou de tout autre développeur interressé.


## A2L_Application 
L'A2L ou Association du Lycée Lurçat se modernise en informatisant ses cartes adhérents. Une application sera déployée sur iOS, et via un site internet afin de permettre aux adhérents d'avoir accès à leur carte et ainsi pouvoir bénéficer d'avantages. Ce code est du site web, d'ores et déjà déployé et disponible pour tous. Elle sera en permamence connectée à un serveur avec lequel elle dialoguera. Le serveur devra gérer les connexions, les privilèges, les informations. Voici le repository du serveur [https://github.com/DevNathan/A2L_BackEnd]. 
3 types d'utilisateurs pourront utiliser le site : 


1) Les adhérents. Ils ne disposent d'aucun privilège particulié et n'ont pas de droits d'écriture. Ils peuvent consulter leurs informations et générer un QR code donnant aux admin l'accès à leurs informations. 


2) Les membres du bureau. Ils disposent de quelques privilèges. Ils leurs sont accordés par les super-admin. Il pourront ainsi visionner la liste des adhérents, augmenter/diminuer le nombre de point de fidelité.


3) Les super-admin ont tous les privilèges. Ils gèrent ceux des autres. Ils possèdent donc les privilèges des membres du bureau, ainsi qu'un droit de modification sur toutes les infromations, la possibilité de supprimer/ajouter des adhérents (en soi il gère les données du serveur), eux seuls peuvent nommer d'autre super-admin, et modifier des données en général. Ils ont accès à des données confidentielles qui ne sont pas présentes sur ce github.


4) Les développeurs : ils disposent de tous les privileges des super-admin et gardent le controlle de l’application. Ainsi ils ne peuvent pas êtres dégradé ni supprimé de la base de donnée. Ils disposeront d’un accès privé au serveur via l’application ainsi que les codes du serveurs.

La sécurité de l'application et du serveur est détaillé dans ce docuement. La sécurité nécessaire sera fournie dès la première version distribuée et les mises à jours permettront d'apporter tous les protocles de sécurités nécessaires. (https://github.com/DevNathan/A2L_BackEnd/blob/master/README.md)
L’application se veut être autonome et doit donc être capable de réagir toute seule à tout type de menace.

Ce site n'a pas pour vocation de remplacer la carte A2L mais de faciliter son utilité. 
Le code source est à la dispositon de tous. 

Toute contribution est bonne à prendre. Le developpeur détenteur de la liscence Apple et du serveur se réserve le droit de la publication des mises à jours. 

Nous rappelons que le rapport de bug est grandement apprécié ainsi que celui des failles potentielles de sécurité. 
#### Si par chance (ou malheur) vous tombez sur une d'entre elles, quelque soit la manière utilisée, il doit être un devoir pour vous de la signaler afin qu'elle puisse être fixée au plus vite. Amis developpeurs, amateurs, sachez que toutes attaques ayant un but malvayent et non préventif seront très sévèrement réprimées. 
A part cela, l'API, le site et l'applications vous sont ouvertes ;)

Liste des developpeurs : [Stchepinsky Nathan (developpeur principal)] 

Contact : nathanstchepinsky@gmail.com 

Site : https://nathanstchepinsky--nathans1.repl.co


