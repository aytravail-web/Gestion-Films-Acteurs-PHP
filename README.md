# SAÉ 2.01 – Développement d’une application Web

## Auteurs

* **Ayoub BOUHIA** – bouh0057
* **Cem BOYRAZ** – boyr0002

---

## Présentation du projet

Cette application Web a été développée en PHP orienté objet dans le cadre de la SAÉ 2.01 (Situation d'Apprentissage Évaluée), qui constitue un projet académique réalisé dans le cadre du BUT Informatique.

Elle permet de consulter et gérer une base de données de films et d’acteurs.

Les données sont stockées dans une base MariaDB et affichées via différentes pages dynamiques.


## Fonctionnalités

### Gestion des films

* Affichage de la liste des films
* Consultation de la fiche détaillée d’un film
* Affichage de l’affiche du film
* Ajout d’un film
* Modification d’un film
* Suppression d’un film
* Filtrage des films par genre

### Gestion des acteurs

* Consultation de la fiche détaillée d’un acteur
* Affichage de sa photographie
* Affichage de sa biographie
* Affichage de son lieu de naissance
* Affichage de ses dates de naissance et décès (si disponibles)
* Affichage de sa filmographie
* Affichage du rôle joué dans chaque film



## Jeux de données

L’application utilise une base de données contenant :

* des films
* des acteurs
* des genres
* les rôles des acteurs
* les affiches des films
* les photographies des acteurs

Les données proviennent de la base fournie dans le cadre de la SAÉ puis importées dans MariaDB.



## Prérequis

* PHP 8.3
* Composer
* Serveur web local (serveur PHP intégré)
* MariaDB



## Installation

1. Cloner le projet :

```bash
git clone https://iut-info.univ-reims.fr/gitlab/bouh0057/sae2-01
```

2. Installer les dépendances :

```bash
composer install
```


## Configuration de la base de données

La connexion à la base de données est gérée par la classe MyPdo.

Dans le cadre de notre environnement de travail à l'IUT, nous avons utilisé un fichier `.mypdo.ini` placé à la racine du projet afin de nous connecter à la base de données MariaDB mise à disposition par l'IUT.

Pour utiliser le projet en dehors de l'environnement de l'IUT, cette configuration ne sera pas disponible. Il est donc nécessaire de disposer de sa propre base de données MariaDB.

Un script SQL est fourni dans le dépôt afin de permettre de créer la base de données et d'importer les données nécessaires au fonctionnement de l'application.

Il suffit d'exécuter ce script SQL dans votre serveur MariaDB, puis d'adapter la configuration de connexion à votre environnement.

Le fichier `.mypdo.ini` utilisé dans notre environnement universitaire n'est pas fourni dans le dépôt, car il contient les informations de connexion à la base de données de l'IUT.
mais il prends la forme suivante :

 ```ini
[mypdo]
dsn="mysql:host=mariadb;dbname=name_movie;charset=utf8"
username=nom_utilisateur
password=mot_de_passe
```

Le chemin du projet est défini via la variable d’environnement APP_DIR automatiquement lors du lancement.


## Lancement de l’application

Démarrer le serveur avec :

```bash
composer run start:linux
```

Puis accéder à l’application via :

```
http://localhost:8000
```



## Qualité du code

Le projet utilise **PHP CS Fixer**.

* Vérifier le code :

```bash
composer run test:cs
```

* Corriger automatiquement :

```bash
composer run fix:cs
```



## Autoloading

L’autoloading est entièrement géré par Composer :

```
auto_prepend_file="vendor/autoload.php"
```

Aucune inclusion manuelle n’est nécessaire.



## Architecture du projet

* `src/Entity` : entités métier
* `src/Entity/Collection` : collections et requêtes
* `src/Database` : accès base de données
* `src/Html` : génération HTML
* `src/Html/Form` : formulaires
* `public` : pages accessibles
* `public/admin` : administration



## Parcours de démonstration

1. Ouvrir la page d’accueil
2. Consulter la liste des films
3. Filtrer par genre
4. Ouvrir un film
5. Voir les acteurs
6. Consulter un acteur
7. Voir sa biographie et filmographie
8. Ajouter un film
9. Modifier un film
10. Supprimer un film



## Remarques

* Le dossier `vendor/` est ignoré (`.gitignore`)
* Les dépendances doivent être installées après clonage
* Le projet repose sur PHP orienté objet + Composer + MariaDB
* Toute nouvelle classe est automatiquement chargée via Composer
