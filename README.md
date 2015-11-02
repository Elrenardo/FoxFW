# ::FoxFW::
Un petit framework que j'ai crée pour faire des sites webs pour mes projets.

Il est basé sur un principe de "bundle" ( inspiré de Symphony2 ) avec une architectures MVC.
le projet est composé de deux parties, la premiére ce trouve dans "_vendor/foxFW" qui est le kernel du site.
le reste est une prêt configuration/architecutre pour créer un pattern de site plus rapide.

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
6. Dans PhpMyAdmin, trouver "foxfwusers" et dans votre compte changer les roles à "ANONYME|MEMBRE|ADMIN|USERS_PERMISSION" pour les autorisations d'admin. Les autres autorisations pourrons être ajouter via le panel admin pour accéder au autre bundle.


# Créer un Bundle

//TODO


# Bundle disponible

//TODO