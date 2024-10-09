# Nom du Projet 
*Gestion des Produits*

## Description
Ce projet est une application de gestion des produits permettant d'ajouter, de visualiser, de supprimer et de filtrer des produits. L'application utilise Vue.js pour le frontend et PHP pour le backend, assurant une expérience utilisateur fluide et réactive.

## Fonctionnalités
- Ajout de nouveaux categorie avec nom dans url http://127.0.0.1:8000/Categories.
- Ajout de nouveaux produits avec nom, description, prix et image.
- Suppression de produits.
- Filtrage des produits par catégorie.
- Tri des produits par nom ou prix.
- Pagination des produits affichés.
- Affichage des détails d'un produit dans une popup.

## Technologies Utilisées
- **Frontend**: Vue.js, Axios
- **Backend**: PHP, Laravel
- **Base de données**: MySQL
- **Stockage des fichiers**: Storage Laravel

## Étapes pour Construire le Projet
### 1. Configuration de l'Environnement
  - Assurez-vous d'avoir installé les logiciels suivants :
    - [Node.js](https://nodejs.org/en/download/) (version LTS recommandée)
    - [Composer](https://getcomposer.org/download/)
    - [PHP](https://www.php.net/downloads) (version 7.2 ou supérieure)
    - [MySQL](https://dev.mysql.com/downloads/mysql/) ou un autre SGBD compatible avec Laravel.

### 2. Cloner le Dépôt
Instructions pour cloner le dépôt sur votre machine :
```bash
git clone https://github.com/OUomar/Coding-Challenge-Software-Engineer-application-by-FirstName-LastName.git
cd Coding-Challenge-Software-Engineer-application-by-FirstName-LastName.git 
```
### 3. Installer les Dépendances
Installez les dépendances backend et frontend :
```bash
    composer install # Pour les dépendances Laravel
    npm install      # Pour les dépendances Vue.js
```

### 4. Configuration de l'Application
Copiez le fichier d'environnement par défaut et configurez vos variables d'environnement :
```bash
    cp .env.example .env
```
Modifiez le fichier .env pour configurer votre base de données et d'autres paramètres.

### 5. Exécuter les Migrations
Exécutez les migrations pour créer les tables nécessaires dans la base de données :
```bash
    php artisan migrate
```

### 6. Démarrer le Serveur
Démarrez le serveur backend avec la commande suivante :
```bash
    php artisan serve
```
### 7. Accéder à l'Application
Ouvrez votre navigateur et allez à l'adresse http://127.0.0.1:8000 pour voir l'application.

### 8. Utilisation de l'Application
Vous pouvez ajouter une catgorie en remplissant son ou un produit en remplissant le formulaire et en spécifiant les détails tels que le nom, la description, le prix et les catégories. Les produits peuvent être filtrés par catégorie et triés par nom ou prix.



