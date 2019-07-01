# ProjetTransverse

**Installer composer**

https://getcomposer.org/

**Cloner le repo Git**

`git init`

`git clone git@github.com:RisbourgNathan/ProjetTransverse.git`

**Télécharger les packages du projet**

Dans le dossier du projet :

`composer install`

**Créer la base de donées**

Dans le dossier du projet :

`php bin/console doctrine:database:create`

`php bin/console make:migration`

`php bin/console doctrine:migraions:migrate`

**Lancer le serveur**

`php bin/console server:run`

**Utilisation**

Consulter le Wiki du Git : https://github.com/RisbourgNathan/ProjetTransverse/wiki
