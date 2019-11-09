# medianet
FELIX Léo
PINOT Antoine
DAL PONTE Simon
Praga Yvain

## Liens utiles

**Tableau de bord du projet**

https://trello.com/b/5A2sTpOp/mediatek-semaine-atelier


## Prérequis
 - php 7.0.0 ou supérieur
 - composer
 - apache2
 - serveur mariadb ou mysql

## Installation de la base de donnée  
Importer le fichier /db/medianet.sql dans votre base de données (des données d'exemples sont déjà présentes)  

## Installation de l'application
Pour chaque application (dossier medianet-staff/ et medianet-users/)
1. Installer le vendor avec: "composer install"
3. Configurer un fichier db.conf.ini dans le dossier src/config (un fichier exemple vous est fourni)
4. Lancer un serveur http sur le fichier src/public/index.php

## Tester l'application
User:  https://webetu.iutnc.univ-lorraine.fr/www/pinot17u/medianet-users/src/public/ 
donnée de test: (email: john.doe@gmail.com, mot de passe: test)
Staff: https://webetu.iutnc.univ-lorraine.fr/www/felix22u/medianet-staff/src/public/
