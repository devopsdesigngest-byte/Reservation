# Changelog

## v0.0.0
Il n'y a que l'initialisation du projet : la routine.

## v0.1.0
J'ai installé les dépendances.
Mon image Docker (dépendances, fichiers projet etc).
Volume pour la persistance.
etc.

## v0.2.0
Ajout de `.env.example`.
Chargement des variables d'environnement.
Configuration de `Capsule\Manager`.
Démarrage d'Eloquent.
Vérification de la connexion.
Création des tables.

## v0.3.0
Ajout de :
App\Model\Salle
App\Model\Reservation
up et down methode dans les migrations

## v0.4.0
Les seeds.
Le script de Mouhamed (sans le reprendre) amélioré vrai commande.

## v0.5.0
Les validations avec normes.

## v0.6.0
DTO + design pattern Builder + validation.

## v0.7.0
Repo.

## v0.8.0
Service.

## v0.9.0
Contrôleurs et vues.
SalleController et ReservationController.
Templates pour salles et réservations, layout de base, pages 404/405.

## v0.10.0
Routing avec nikic/fast-route.
Connexion des URLs aux bonnes méthodes de contrôleur.

## v0.11.0
Ajustements sur les repositories et services (correction des signatures DTO/modèle): injection.

## v0.12.0
Les tests.
Tests unitaires du service de création (8 scénarios), du service d'annulation, des validateurs.
Doublures en mémoire pour tester sans MySQL. sqlite donnée invisible
Tests d'intégration Eloquent.

## v0.13.0
Finalisation.
Mise en forme CSS.
Messages de succès/erreur.
Gestion propre des exceptions.
README et CHANGELOG complétés.
Diagramme de classes.
Courte analyse.
Vérifiez l’installation depuis un dépôt fraîchement cloné.
Corrigez les anomalies.

## v0.14.0
Bonus
