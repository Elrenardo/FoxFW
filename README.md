# ::FoxFW::
( version 5 en dev )
//TODO

Il utilise les librairies suivantes:
- [AltoRouter] (https://github.com/dannyvankooten/AltoRouter "AltoRouter")
- [CodeMirror] (https://github.com/codemirror/codemirror "CodeMirror")
- [DropZone] (https://github.com/enyo/dropzone "DropZone")
- [PHPMailer] (https://github.com/PHPMailer/PHPMailer "PHPMailer")
- [RedBean] (http://www.redbeanphp.com/ "RedBean")
- [Twig] (http://twig.sensiolabs.org/ "Twig")

# Configuration & installation

1. Copier les fichiers dans le répértoir de votre serveur.
2. Ouvrer le fichier "_vendor/foxFW/config.json"
3. Trouver le paramettre "BasePath" dans "AltoRouter". Modifier le chemain path celons votre arborescence. ( si sur serveur: "BasePath":"" )
4. Configurer l'accés de la base de donner dans "RedBean"
5. Aller sur le site est créer un nouvel utilisateur "127.0.0.1/user/login" ( RedBean créera les tables automatiquent )
6. Dans PhpMyAdmin, trouver "foxfwusers" et dans votre compte changer les roles à "ANONYME|MEMBRE|ADMIN|USERS_PERMISSION|CONFIG" pour les autorisations d'admin. Les autres autorisations pourrons être ajouter via le panel admin pour accéder au autre bundle.

>Le dossier "site" contient le bundle principal du site. Tout ce qui touche à la configuration du site ou interface se fera dans ce bundle.

>Le dossier "bundle" contient les bundles site, ce dossier normalement ne dois pas être modifié. Si des fichiers doivent être modifiés: copier le fichier en question dans le bundle "site" où il sera chargé à la place de l'original.

>Le dossier "vendor" contient le noyau FoxFW ainsi que les autres projets utilisé pour son fonctionnement.>Le dossier "web" contient les fichiers et dossier généré par les bundles ainsi que les images et document du site.

//TODO

# Créer un Bundle

//TODO


# Bundle disponible
//TODO

# Configuration Multi-site.

Déplacé les dossiers "bundle"&"vendor", dans un espace commun et créer un lien dynamique ( linux ) dans votre répertoire pour qu'ils puissent être utiliser depuis plusieurs sites ou sous-domaine. 

Les autres dossiers et fichier sont propres a chaque site. Adapté la configuration dans "config.json" au besoin et "index.php".

Dans le dossier config.json: l'utilisation d'un champ "bundle" permet de sélectionner qu'elles seront les bundles à charger ( par défaut tous les bundles ce chargent )
