Voici une version plus simple, courte et facile à expliquer à l'oral, tout en gardant les 5 points demandés.

MVC
Classes concernées : SalleController, templates/salle/*.php, Salle
Rôle : Sépare les données, la logique et l'affichage.
Avantage : Le code est plus clair et plus facile à maintenir.
Limite : Peut être trop complexe pour un petit projet.
Extrait : $salleController->index();Le contrôleur récupère les salles puis affiche la vue.

Front Controller
Classes concernées : public/index.php
Rôle : Reçoit toutes les requêtes de l'application.
Avantage : Centralise le démarrage, le routing et les erreurs.
Limite : Peut devenir trop gros s'il contient trop de logique.
Extrait : Toutes les requêtes passent par index.php.

Router
Classes concernées : routes/web.php, FastRoute\Dispatcher
Rôle : Relie une URL à une action d'un contrôleur.
Avantage : Sépare les URLs du fonctionnement interne.
Limite : Une mauvaise route peut provoquer une erreur 404.
Extrait : $r->addRoute('GET', '/salles/{id:\d+}', ['SalleController', 'show']);

Validator
Classes concernées : ValidatorInterface, SalleValidator, ReservationValidator
Rôle : Vérifie que les données sont correctes.
Avantage : Évite de répéter les mêmes règles.
Limite : Les règles doivent rester cohérentes avec la base de données.
Extrait : v::stringType()->length(2, 100)

Vérifie que le nom contient entre 2 et 100 caractères.

DTO
Classes concernées : CreerSalleDTO, CreerReservationDTO
Rôle : Transporte les données entre les différentes couches.
Avantage : Les données sont structurées et typées.
Limite : Ajoute des classes supplémentaires.
Extrait : public readonly string $nom;
La valeur ne peut plus être modifiée après création.

ORM
Classes concernées : Eloquent, Illuminate\Database
Rôle : Permet de communiquer avec la base de données sans écrire directement tout le SQL.
Avantage : Simplifie les requêtes SQL.
Limite : Peut produire des requêtes inefficaces dans certains cas.
Extrait : Salle::query()->get()

Active Record
Classes concernées : Salle, Reservation
Rôle : Un objet représente une ligne de la base de données.
Avantage : Simple et rapide à utiliser.
Limite : Mélange les données et la persistance.
Extrait : $salle->save();

Repository
Classes concernées : SalleRepositoryInterface, EloquentSalleRepository
Rôle : Sépare l'accès aux données du reste de l'application.
Avantage : Permet de changer la façon d'accéder aux données.
Limite : Ajoute une couche supplémentaire.
Extrait : 
interface SalleRepositoryInterface
{
    public function trouver(int $id): ?Salle;
}

Service
Classes concernées : CreerReservationService, AnnulerReservationService
Rôle : Contient les règles métier.
Avantage : Centralise la logique métier.
Limite : Peut devenir trop gros s'il contient trop de règles.
Extrait :
if ($heures > 4) {
    throw new SalleIndisponibleException(...);
}

Injection par constructeur
Classes concernées : CreerReservationService
Rôle : Reçoit ses dépendances depuis l'extérieur.
Avantage : Facilite les tests.
Limite : Le constructeur peut avoir beaucoup de paramètres.
Extrait : 
public function __construct(
    SalleRepositoryInterface $salleRepository
)

Conteneur d'injection
Classes concernées : Container, Application
Rôle : Crée automatiquement les objets et leurs dépendances.
Avantage : Évite de tout créer manuellement.
Limite : Peut rendre le fonctionnement moins visible.
Extrait : $container->get(Application::class);

Autowiring
Classes concernées : ContainerBuilder, classes avec dépendances
Rôle : Le conteneur trouve automatiquement les dépendances.
Avantage : Réduit la configuration.
Limite : Le fonctionnement peut être moins explicite.
Extrait : autowire()

Inversion de contrôle
Classes concernées : Services et contrôleurs utilisant des interfaces.
Rôle : Les dépendances sont fournies au lieu d'être créées par la classe.
Avantage : Facilite le remplacement des implémentations.
Limite : Peut rendre le code plus difficile à suivre.
Extrait : private SalleRepositoryInterface $salleRepository;


Principes SOLID
Classes concernées : Plusieurs classes du projet.
Rôle : Cinq principes pour avoir un code propre et maintenable.
Avantage : Facilite les modifications et limite les problèmes.
Limite : Peut créer trop de classes si on l'applique excessivement.
S — Single Responsibility
Une classe doit avoir une seule responsabilité.
SalleValidator

→ S'occupe uniquement de la validation.
O — Open/Closed
Une classe doit pouvoir être étendue sans modifier l'existant.
ValidatorInterface
→ On peut ajouter un nouveau validateur.

L — Liskov Substitution
Une implémentation doit pouvoir remplacer son interface.
SalleRepositoryInterface
→ EloquentSalleRepository peut l'implémenter.

I — Interface Segregation
Une interface ne doit contenir que les méthodes nécessaires.
SalleRepositoryInterface
→ Elle contient les méthodes liées aux salles.

D — Dependency Inversion
Le code doit dépendre des abstractions, pas des implémentations concrètes.
CreerReservationService
→ dépend de :
ReservationRepositoryInterface
et non directement de :
EloquentReservationRepository