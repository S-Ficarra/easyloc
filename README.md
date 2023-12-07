# **Documentation**

# **Introduction**
Bienvenue dans la documentation de l'application EasyLoc. Cette application a été développée pour gérer une liste de véhicules et de contrats de location.

# **Configuration**
Environnement
L'application utilise le framework Symfony. Assurez-vous d'avoir les prérequis suivants installés :
PHP 8.1.2
Composer 2.6.5
(Voir la liste des autres dépendances dans le fichier Excel en annexe)

# **Base de données**
L'application utilise deux types de bases de données : SQL Server et MongoDB.
Pour la base de données SQL Server, configurez les paramètres dans le fichier dotrine.yaml, pour MongoDB, configurez les paramètres dans le fichier .env.

# **Structure du Projet**
├── bin
│   ├── console
│   └── phpunit
├── config
│   ├── packages
│   │   ├── cache.yaml
│   │   ├── doctrine.yaml
│   │   ├── doctrine_migrations.yaml
│   │   ├── doctrine_mongodb.yaml
│   │   ├── framework.yaml
│   │   ├── routing.yaml
│   │   ├── twig.yaml
│   │   └── validator.yaml
│   ├── routes
│   │   └── framework.yaml
│   ├── bundles.php
│   ├── preload.php
│   ├── routes.yaml
│   └── services.yaml
├── docker
│   ├── php
│   │   └── Dockerfile
│   └── docker-compose.yml
├── migrations
│   └── Version20231129155043.php
├── public
│   └── index.php
├── src
│   ├── Command
│   │   └── AddVehicleCommand.php
│   ├── Controller
│   │   ├── ContractController.php
│   │   ├── IndexController.php
│   │   └── VehicleController.php
│   ├── Document
│   │   ├── CustomerDocument.php
│   │   └── VehicleDocument.php
│   ├── Entity
│   │   └── Contract.php
│   ├── Form
│   │   ├── ContractType.php
│   │   └── VehicleType.php
│   ├── Repository
│   │   └── ContractRepository.php
│   └── Kernel.php
├── templates
│   ├── contract
│   │   ├── _form.html.twig
│   │   ├── delete.html.twig
│   │   ├── edit.html.twig
│   │   ├── index.html.twig
│   │   └── new.html.twig
│   ├── ajouter_vehicule.html.twig
│   ├── base.html.twig
│   ├── index.html.twig
│   ├── modifier_vehicule.html.twig
│   ├── rechercher_vehicule.html.twig
│   └── supprimer_vehicule.html.twig
├── tests
│   ├── VehicleControllerTest.php
│   └── bootstrap.php
├── var
│   ├── cache
│   │   ├── dev
│   │   ├── prod
│   │   └── test
│   └── log
├── README.md
├── compose.override.yaml
├── compose.yaml
├── composer.json
├── composer.lock
├── phpunit.xml.dist
└── symfony.lock

# **Contrôleurs**
VehicleController
Le VehicleController gère les opérations liées aux véhicules au sein de l'application. Voici une explication des principales fonctions du contrôleur :

Ajouter un Véhicule (ajouterVehicule) :
-	Cette action permet d'afficher le formulaire pour ajouter un nouveau véhicule.
-	Elle prend en charge la soumission du formulaire et l'ajout du véhicule dans la base de données.
Rechercher des Véhicules (rechercherVehicule) :
-	Affiche un formulaire de recherche pour filtrer les véhicules en fonction de critères spécifiques (ID, plaque d'immatriculation, kilométrage).
-	Traite les données de recherche et affiche les résultats correspondants.
-	
Modifier un Véhicule (modifierVehicule) :
-	Cette action permet d'afficher le formulaire de modification d'un véhicule existant.
-	Traite la soumission du formulaire et met à jour les informations du véhicule dans la base de données.
-	
Supprimer un Véhicule (supprimerVehicule) :
-	Affiche une confirmation pour la suppression d'un véhicule.
-	Traite la confirmation et supprime le véhicule de la base de données.


ContractController
Le ContractController est responsable de la gestion des contrats au sein de l'application. Voici une explication des principales fonctions du contrôleur :

Afficher les Contrats (index) :
-	Cette action affiche la liste des contrats disponibles, avec des détails tels que l'ID, le véhicule associé, la date de signature, les dates de location, etc.
-	
Ajouter un Contrat (new) :
-	Affiche le formulaire permettant de créer un nouveau contrat.
-	Traite la soumission du formulaire et enregistre le nouveau contrat dans la base de données.

Modifier un Contrat (edit) :
-	Cette action affiche le formulaire de modification d'un contrat existant.
-	Traite la soumission du formulaire et met à jour les informations du contrat dans la base de données.

Supprimer un Contrat (delete) :
-	Affiche une confirmation pour la suppression d'un contrat.
-	Traite la confirmation et supprime le contrat de la base de données.


# **Modèles**
Modèle : VehicleDocument
Le modèle VehicleDocument représente les informations relatives à un véhicule dans l'application, il est créé au format Document pour être stocké dans une BDD NoSQL.

Champs Principaux :
-	id : Identifiant unique du véhicule (UUID).
-	licencePlate : Plaque d'immatriculation du véhicule (STRING).
-	informations : Informations générales sur le véhicule (STRING).
-	km : Kilométrage du véhicule (INT).

Modèle : Contract
Le modèle Contract représente un contrat de location entre un client et un véhicule, il est créé au format Entity pour être stockée dans une BDD SQL.

Champs Principaux :
-	id : Identifiant unique du contrat (UUID).
-	vehicle_uid : UID du véhicule associé au contrat (UUID).
-	customer_uid : UID du client associé au contrat (UUID).
-	sign_datetime : Date et heure de signature du contrat (DATE).
-	loc_begin_datetime : Date et heure de début de location (DATE).
-	loc_end_datetime : Date et heure de fin de location(DATE).
-	returning_datetime : Date et heure de retour prévue (peut être nul) (DATE).
-	price : Prix du contrat (MONEY).
-	
# **Vues**
Vue : ajouter_vehicule.html.twig
Objectif :
Cette vue est destinée à l'ajout d'un nouveau véhicule dans le système.
Organisation :
Formulaire pour saisir les détails du nouveau véhicule, tels que la plaque d'immatriculation, les informations et le kilométrage.
Bouton de validation pour soumettre le formulaire.

Vue : modifier_vehicule.html.twig
Objectif :
Cette vue permet de modifier les détails d'un véhicule existant.
Organisation :
Formulaire pré-rempli avec les détails actuels du véhicule.
Possibilité de modifier la plaque d'immatriculation, les informations et le kilométrage.
Bouton de validation pour soumettre les modifications.

Vue : rechercher_vehicule.html.twig
Objectif :
Cette vue permet de rechercher des véhicules en fonction de différents critères.
Organisation :
Formulaires de recherche avec des champs pour saisir l'ID, la plaque d'immatriculation et le kilométrage.
Bouton de recherche pour soumettre les critères de recherche.
Affichage des résultats de la recherche avec la possibilité de modifier ou supprimer chaque véhicule.

Vue : supprimer_vehicule.html.twig
Objectif :
Cette vue permet de confirmer la suppression d'un véhicule.
Organisation :
Affichage des détails du véhicule à supprimer.
Bouton de confirmation pour supprimer le véhicule.

Vue : base.html.twig
Objectif :
Ce fichier est un modèle de base utilisé par toutes les autres vues pour assurer une mise en page cohérente.
Organisation :
Section <head> avec les balises meta et les liens vers les feuilles de style Bootstrap.
Bloc <body> pour afficher le contenu spécifique à chaque page.
Des blocs sont définis pour permettre des extensions et des personnalisations dans les vues spécifiques.

Vue : index.html.twig
Objectif :
Vue d'accueil, affichant des liens pour accéder aux contrats et aux véhicules.
Organisation :
Liens vers les pages "Contrats" et "Véhicules".

Vue : contract/index.html.twig
Objectif :
Cette vue permet de rechercher des contrats en fonction de différents critères.
Organisation :
Formulaires de recherche avec des champs pour saisir l'ID, l'UID du véhicule, l'UID du client et la plage de dates.
Bouton de recherche pour soumettre les critères de recherche.
Affichage des résultats de la recherche avec la possibilité de modifier ou supprimer chaque contrat.

Vue : contract/new.html.twig
Objectif :
Vue pour ajouter un nouveau contrat.
Organisation :
Formulaire pour saisir les détails du nouveau contrat, tels que l'UID du véhicule, l'UID du client, les dates et le prix.
Bouton de validation pour soumettre le formulaire.

Vue : contract/edit.html.twig
Objectif :
Vue pour modifier les détails d'un contrat existant.
Organisation :
Formulaire pré-rempli avec les détails actuels du contrat.
Possibilité de modifier l'UID du véhicule, l'UID du client, les dates et le prix.
Bouton de validation pour soumettre les modifications.

Vue : contract/delete.html.twig
Objectif :
Vue de confirmation pour supprimer un contrat.
Organisation :
Affichage des détails du contrat à supprimer.
Bouton de confirmation pour supprimer le contrat.

Vue : index_contrat.html.twig
Objectif :
Vue affichant la liste des contrats.
Organisation :
Tableau affichant les détails de chaque contrat avec des liens pour les modifier ou les supprimer.
Liens pour ajouter un nouveau contrat et revenir à l'accueil.

Vue : _form.html.twig (Partagée entre ajouter_contrat.html.twig et modifier_contrat.html.twig)
Objectif :
Vue partielle contenant le formulaire pour les actions d'ajout et de modification de contrat.
Organisation :
Formulaire pour saisir les détails du contrat, partagé entre les vues d'ajout et de modification.

# **Routes**
Route : /
-	Controller : App\Controller\IndexController::indexPage
-	Objectif : Page d'accueil avec des liens vers les contrats et les véhicules.
-	Utilisation : Accéder à la page d'accueil de l'application.

Route : /ajouter-vehicule
-	Controller : App\Controller\VehicleController::ajouterVehicule
-	Objectif : Ajouter un nouveau véhicule dans le système.
-	Utilisation : Accéder à la page d'ajout de véhicule.
Route : /rechercher-vehicule
-	Controller : App\Controller\VehicleController::rechercherVehicule
-	Objectif : Rechercher des véhicules en fonction de différents critères.
-	Utilisation : Accéder à la page de recherche de véhicules.

Route : /modifier-vehicule/{licencePlate}
-	Controller : App\Controller\VehicleController::modifierVehicule
-	Objectif : Modifier les détails d'un véhicule existant.
-	Utilisation : Accéder à la page de modification d'un véhicule spécifique.

Route : /supprimer-vehicule/{licencePlate}
-	Controller : App\Controller\VehicleController::supprimerVehicule
-	Objectif : Confirmer et supprimer un véhicule spécifique.
-	Utilisation : Accéder à la page de suppression d'un véhicule.

Route : /afficher-contrat
-	Controller : App\Controller\ContractController::index
-	Objectif : Afficher la liste des contrats.
-	Utilisation : Accéder à la page d'affichage des contrats.

Route : /ajouter-contrat
-	Controller : App\Controller\ContractController::new
-	Objectif : Ajouter un nouveau contrat dans le système.
-	Utilisation : Accéder à la page d'ajout de contrat.

Route : /modifier-contrat/{id}
-	Controller : App\Controller\ContractController::edit
-	Objectif : Modifier les détails d'un contrat existant.
-	Utilisation : Accéder à la page de modification d'un contrat spécifique.
-	
Route : /supprimer-contrat/{id}
-	Controller : App\Controller\ContractController::delete
-	Objectif : Confirmer et supprimer un contrat spécifique.
-	Utilisation : Accéder à la page de suppression d'un contrat.


Comment utiliser les routes
Accédez à ces routes via le navigateur en ajoutant l'URL correspondante après le domaine de l’application.
Les formulaires sur ces pages vous guideront pour effectuer les actions associées, telles que l'ajout, la recherche, la modification ou la suppression de véhicules et de contrats.

# **Installation**
Assurez-vous d'avoir installé Docker et Docker Compose sur votre machine avant de continuer.
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

Clonez ce dépôt sur votre machine :
```
git clone https://github.com/S-Ficarra/easyloc
```

Accédez au répertoire du projet :
```
cd easyloc
```
Copiez le fichier .env.dist et renommez-le en .env :
```
cp .env.dist .env
```
Modifiez le fichier .env selon vos besoins.

Construisez et démarrez les conteneurs Docker :
```
docker-compose up --build
```
Cela créera et démarrera les conteneurs pour PHP, MongoDB, SQL Server, et votre application Symfony.

Installez les dépendances de l'application Symfony :
```
docker-compose exec php composer install
```

Accédez au conteneur Symfony et exécutez les migrations (le cas échéant) :
```
docker-compose exec php php bin/console doctrine:migrations:migrate
```
Le serveur Symfony devrait être accessible à l'adresse http://localhost:8000.

Arrêt des conteneurs
Pour arrêter les conteneurs Docker, exécutez la commande suivante dans le répertoire du projet :
```
docker-compose down
```
Cela arrêtera et supprimera les conteneurs.

Personnalisation
Pour personnaliser la configuration du serveur Symfony, modifiez le fichier docker-compose.yml et le Dockerfile au besoin.
Assurez-vous de configurer correctement les paramètres de base de données dans le fichier .env de votre application Symfony.

Problèmes Connus
Si vous rencontrez des problèmes de permissions, assurez-vous que les fichiers du projet ont les bonnes permissions. Vous pouvez ajuster les permissions avec les commandes suivantes :
sudo chown -R $USER:$USER .

# **Commande d'Ajout de Véhicule**
Objectif
Cette commande permet d'ajouter un nouveau véhicule à la base de données via la ligne de commande Symfony. 

Utilisation
Pour ajouter un véhicule, exécutez la commande suivante dans votre terminal :
```
bin/console app:add-vehicle
```
La commande guidera l'utilisateur pour entrer les informations nécessaires telles que la plaque d'immatriculation, les informations sur le véhicule et le kilométrage.

Détails Techniques
La commande est implémentée dans la classe AddVehicleCommand. Elle utilise le service Doctrine MongoDB ODM pour interagir avec la base de données MongoDB et stocker le nouveau véhicule.



Commentaires
La commande vérifie la validité des données entrées, comme le format de la plaque d'immatriculation, pour garantir la cohérence des données stockées.
En cas de succès, un message indiquant le succès de l'opération est affiché. En cas d'échec, des messages d'erreur explicites sont fournis pour aider l'utilisateur à corriger les erreurs.

# **Test de validation du formulaire d'ajout de véhicule**
Objectif du Test :
Vérifier que le formulaire d'ajout de véhicule fonctionne correctement en soumettant des données valides et en s'assurant qu'un message de succès approprié est affiché.

Procédure du Test :
Initialisation : Le client Symfony est créé en utilisant static::createClient(), et une requête GET est envoyée pour récupérer la page du formulaire d'ajout de véhicule à l'URL /ajouter-vehicule.
```
$client = static::createClient();
$crawler = $client->request('GET', '/ajouter-vehicule');
```

Sélection du formulaire : 
Le formulaire est sélectionné à l'aide de la méthode selectButton en recherchant le bouton ayant la valeur 'Valider'.
```
$form = $crawler->selectButton('Valider')->form();
```

Remplissage du formulaire : 
Des données valides sont remplies dans le formulaire. Dans ce cas, la plaque d'immatriculation est définie sur 'AA123AA', les informations sur le véhicule sur 'Informations sur le véhicule' et le kilométrage sur 50000.
```
$form['vehicle[licencePlate]'] = 'AA123AA';
$form['vehicle[informations]'] = 'Informations sur le véhicule';
$form['vehicle[km]'] = 50000;
```

Soumission du formulaire : 
Le formulaire est soumis en utilisant la méthode submit du client Symfony.
```
$client->submit($form);
```

Vérification de la réponse : 
L'assertion assertSelectorTextContains est utilisée pour vérifier que la classe CSS .alert-success contient le texte 'ajouté'.
```
$this->assertSelectorTextContains('.alert-success', 'ajouté');
```

Résultat Attendu :
Le test réussira si le formulaire est soumis avec succès, et un message de succès contenant le mot 'ajouté' est affiché à l'utilisateur.









