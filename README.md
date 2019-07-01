# ProjetTransverse B2 - Leblanc Marie, Agostini Raphël, Risbourg Nathan

## Documentation
La documentation générée à l'aide de doxygen en format HTML est disponible dans le dossier "documentation".

## Installation du projet

**Installer PostgresSQL**

https://www.postgresql.org/download/

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

En cas d'erreur lors du chargement de la page d'accueil : 

`composer update`


**Passer en mode production**

Pour changer le mode, il est nécéssaire de changer le .env

A la ligne 7 :

`APP_ENV=prod`

`APP_DEBUG=0`

Puis clean le cache

`php bin/console cache:clear`

**Utilisation**

Consulter le Wiki du Git : https://github.com/RisbourgNathan/ProjetTransverse/wiki

**Utilisation sans dump de la BDD**

Si vous ne faites pas de dump, vous devez créer manuellement le premier compte administrateur :

https://github.com/RisbourgNathan/ProjetTransverse/wiki/Cr%C3%A9ation-d'un-admin
