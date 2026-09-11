# Réservation de salles
Application web de gestion de réservation de salles, en PHP 8.3 avec Eloquent ORM, sans framework complet.

## Prérequis
- La programmation orienté objet : c'est l'approche en vogue.
- Les dépendances sur celles dans https://packagist.org/
- MVC

## Installation des dépendances
Les dépendances PHP (Composer) sont installées automatiquement lors du build de l'image Docker : docker compose build
Docker / Docker Compose
- PHP 8.3 (CLI)
- Eloquent ORM (illuminate/database)
- MySQL 8.0
- nikic/fast-route (routing)
- Respect\Validation (validation)
- PHPUnit (tests)

## Configuration de la base
Copier le fichier d'exemple et l'adapter si besoin

## Création des tables
Exécuter les migrations :
docker compose exec app php bin/console ndiassembow:migrate

## Ajout des données initiales
Le seed (5 salles de base) est exécuté automatiquement à la suite des migrations, dans la même commande ci-dessus.

## Lancement du serveur
Le serveur PHP démarre automatiquement avec notre conteneur.

## Exécution des tests
Tests unitaires (sans MySQL) :
docker compose exec app vendor/bin/phpunit --testsuite Unit
Tests d'intégration (nécessite MySQL démarré) :
docker compose exec app vendor/bin/phpunit --testsuite Integration
docker compose exec app vendor/bin/phpunit


## une courte analyse des choix architecturaux.


    Le projet suit une architecture en couches inspirée du MVC, avec une séparation stricte des responsabilités : contrôleurs (HTTP), services (règles métier), repositories (accès aux données), validateurs (forme des données) et DTO (transport). Ce découpage évite qu'une seule classe cumule plusieurs responsabilités, et facilite les tests unitaires — le service de création de réservation, par exemple, se teste entièrement sans base de données grâce à l'injection de faux repositories.

    Le choix d'Eloquent en mode autonome (via Capsule\Manager, sans Laravel complet) permet de bénéficier d'un ORM mature tout en gardant un projet léger, adapté à un contexte pédagogique. La couche Repository ajoutée au-dessus d'Eloquent introduit une abstraction supplémentaire : elle n'est pas strictement nécessaire techniquement, mais elle illustre l'inversion de dépendance et prépare le code à un éventuel changement de technologie de persistance.

    Le pattern DTO + Builder garantit qu'aucune donnée non validée ne peut atteindre la couche métier — un compromis volontaire entre rigueur et complexité, assumé pour renforcer la fiabilité des entrées utilisateur.

    Le conteneur d'injection ou d'autowiring pour centraliser les injections.