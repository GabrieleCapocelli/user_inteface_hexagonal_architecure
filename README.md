<h1>HEXAGONAL ARCHITECTURE IMPLEMENTATION FOR A USER MANAGEMENT INTERFACE</h1>

<ul>
    <li><a href="#init">INIT</a></li>
    <li><a href="#doc">DOCUMENTATION</a>
        <ul>
             <li><a href="#endpoints">endpoints</a></li>  
             <li><a href="#securite">sécurité</a></li>
             <li><a href="#voters">voters et droits</a></li>
             <li><a href="#implementation">implementation</a></li>
             <li><a href="#tests">tests</a></li>   
        </ul>
    </li>
</ul>



<h2 id="init">INIT</h2>
    
    
##### démarrer l'application
```
docker compose up -d 
```
    
##### accéder au container
```
docker compose exec -it api /bin/bash
```
    
#### créer la base de données, mettre à jour le schema et charger les fixtures
```
bin/console d:d:c
bin/console d:s:u -f --complete
echo yes | bin/console d:f:l
```
    
#### lancer les tests
```
bin/phpunit
```
    
#### sortir du container
```
exit
```
    
#### fermer l’application et retirer les conteneurs
```
docker compose stop
docker compose rm
```



<br>

<h2 id="doc">DOCUMENTATION</h2>


<h3 id="endpoints">ENDPOINTS</h3>

|    Action     |              Url               | Method |
|:-------------:|:------------------------------:|:------:|
|     Login     |        /api/auth/login         |  POST  |
|  Create User  |         /api/v1/users          |  POST  | 
|  Delete User  |     /api/v1/users/{userId}     | DELETE |  
|   Edit User   |     /api/v1/users/{userId}     |  PUT   |  
|   Show User   |     /api/v1/users/{userId}     |  GET   |   
|  Index Users  |         /api/v1/users          |  GET   |   
| Export Users  |      /api/v1/usersExport       |  GET   | 
| Create Equipe |        /api/v1/equipes         |  POST  | 
| Delete Equipe | /api/v1/equipes/{equipeId} | DELETE |   
|  Edit Equipe  | /api/v1/equipes/{equipeId} |  PUT   |   
|  Show Equipe  | /api/v1/equipes/{equipeId} |  GET   |   
| Index Equipes |        /api/v1/equipes         |  GET   |   



<br>

<h4>ENDPOINT BODY PARAMETERS</h4>
<ul>
<li>
    <h4>LOGIN</h4>

        "username": STRING, NOT NULL
        "email": STRING, NOT NULL
</li>
<li>
    <h4>CREATE USER</h4>
        
        "nom": STRING, NOT NULL
        "prenom": STRING, NOT NULL
        "email": STRING, NOT NULL
        "password": STRING, NOT NULL
        "roles": ARRAY, NOT NULL
        "equipe": STRING, NULL
</li>

<li>
    EDIT USER
          
        "id": STRING, NOT NULL
        "nom": STRING, NOT NULL
        "prenom": STRING, NOT NULL
        "email": STRING, NOT NULL
        "roles": ARRAY, NOT NULL
        "equipe": STRING, NULL
</li>

<li>
    CREATE EQUIPE

        "nom": STRING, NOT NULL
</li>

<li>
    EDIT EQUIPE

        "id": STRING, NOT NULL
        "nom": STRING, NOT NULL
</li>
</ul>

<br>
<h4>ENDPOINTS RETURN BODY</h4>
<ul>
<li>
    INDEX USERS (OBJECTS ARRAY)
        
    [
        {
            "id": "0613f6ee-ea2f-4e6f-93f0-ff6add88006e",
            "prenom": "Jacqueline",
            "nom": "Robert",
            "email": "employe5@company.app",
            "roles": [
                "ROLE_EMPLOYE"
            ],
            "equipeId": "6060e8ed-bc35-42ba-ac70-5e5a719316f4",
            "equipeNom": "equipe2"
        },
        ...
    ]
</li>
<li>
    SHOW USER (OBJECT)
        
        {
            "id": "0613f6ee-ea2f-4e6f-93f0-ff6add88006e",
            "prenom": "Jacqueline",
            "nom": "Robert",
            "email": "employe5@company.app",
            "roles": [
                "ROLE_EMPLOYE"
            ],
            "equipeId": "6060e8ed-bc35-42ba-ac70-5e5a719316f4",
            "equipeNom": "equipe2"
        }
</li>
<li>
    INDEX EQUIPES (OBJECTS ARRAY)

        [
            {
                "id": "6060e8ed-bc35-42ba-ac70-5e5a719316f4",
                "nom": "equipe2"
            },
            ...
        ]
</li>
<li>
    SHOW EQUIPE

        {
            "id": "a1e63ca8-b1af-4a37-8508-38fc53709bce",
            "nom": "equipe1"
        }
</li>
</ul>

<br>

<h3 id="securite">SECURITE (config/packages/security.yaml)</h3>

L’application utilise le package lexik/jwt-authentication-bundle. <br>
L'endpoint '/api/v1/auth/login' doit être utilisé pour obtenir un JWT. <br>
Il faudra authentifier toutes les requêtes en passant le JWT dans un header Authorization. <br>

Role hierarchy: <br>
<ul>
<li>ROLE_ADMIN</li>
<li>ROLE_CHEF</li>
<li>ROLE_EMPLOYE</li>
</ul>

Toutes les routes, à l’exception de la route de connexion, sont protégées par le firewall 'main', <br> et le rôle minimum d’accès est ROLE_EMPLOYE.

<br>

<h3 id="voters">VOTERS ET DROITS (src/Api/Security/Voters)</h3>
Les droits sur les operations CRUD sont gérés par des voters (un voter par ressource).

<ul>
    <li>
        <ul>
            <li>USERS</li>
            <li>
                <ul>
                    <li>INDEX: tous</li>
                    <li>SHOW: tous</li>
                    <li>CREATE: admins et chefs du userId</li>
                    <li>EDIT: admins, chefs du userId et userId </li>
                    <li>DELETE: admins et chefs du userId</li>
                </ul>
            </li>
        </ul>
    </li>
    <li>
        <ul>
            <li>EQUIPES</li>
            <li>
                <ul>
                    <li>INDEX: tous</li>
                    <li>SHOW: tous</li>
                    <li>CREATE: admins</li>
                    <li>EDIT: admins et chefs du equipeId </li>
                    <li>DELETE: admins et chefs du equipeId</li>
                </ul>
            </li>
        </ul>
    </li>
</ul>

<h3 id="implementation">IMPLEMENTATION (src/)</h3>

Bien que la logique inhérente à l’application ne soit pas extrêmement complexe, 
j’ai développé son arborescence en suivant les principes du "Hexagonal Architecture".


``` 
src
├── Api
│   ├── Controller
│   │   ├── Equipe
│   │   └── User
│   ├── Kernel.php
│   ├── Security
│   │   └── Voter
│   └── Subscriber
├── Application
│   ├── Commands
│   │   ├── Command
│   │   └── Handler
│   └── Queries
│       ├── DTO
│       └── Query
├── Domain
│   ├── Entity
│   ├── Exceptions
│   ├── Repository
│   ├── Service
│   │   ├── Equipe
│   │   └── User
│   └── ValueObject
└── Infra
    ├── DataFixtures
    ├── EntitiesMapping
    │   ├── dev
    │   └── test
    └── Repository
```

<h4>Api</h4>
La tâche de ce namespace est de recevoir des requêtes http depuis le front et d’appeler le bon service dans le layer suivant. <br>
 * Les demandes de type GET sont traitées en appelant les méthodes du service Queries du layer Application via injection de dépendance. <br>
 * Les demandes de type POST/PUT/DELETE sont envoyées de manière synchrone via bus au service Commands du layer Application. <br>
 * Des Voters gérent les droits et un Event Subscriber s'occupe d'écouter les Exceptions et de les retourner en json. <br>

<h4>Application</h4>
Ce layer représente les Use Cases de l'application et est développé en suivant le pattern CQRS. <br>
 * Le namespace Query s'occupe d'appeler le repository approprié et de retourner la réponse du database sous forme de DTO au controller. <br>
 * Le namespace Commands s'occupe de recevoir et gérer les messages du Controller en appelant le service approprié du layer Domain. <br>

<h4>Domain</h4>
Le namespace Domain est le core de l'application il héberge la logique métier et j'ai essayé de rester le plus framework-agnostic possible en son sein. <br>
 * Les Entities sont conçues de maniere non-anemique à l'aide des named constructors et il n'est pas possible de les instancier dans une êtat invalide. <br>
 * Les Id sont implémentés sous forme de Value Object pour assurer le Information Hiding. <br>
 * Les Services s'occupent de recevoir et gérer les requêtes qui arrivent depuis le layer Application et s'assurent que la logique interne soit respectée. <br>
 * Les Repositories fournissent des interfaces pour le layer Infra. <br>

<h4>Infra</h4>
Le layer Infra s'occupe de récuperer et persister la donnée.
 * Pour un meilleur contrôle et une meilleure flexibilité, j'ai implémenté les repositories en utilisant les api du DBAL de Doctrine. Les queries sont donc executés à l'aide de custom DQLs, sans l'intervention de l'ORM.
 * L'ORM, par contre, a été utilisé pour génerer automatiquement le database et mettre à jour le schema en mappant en yml les Entities.

<h3 id="tests">TESTS</h3>
En considérant le scope du test, je n'ai pas cherché le 100% de code coverage et je n'ai testé aucune des méthodes que l'on trouve normalement dans des projets PHP (getters and setters, constructors etc.). <br>
Je n’ai donc testé que quelques-unes des méthodes propres à cette application, en implémentant des tests d’intégration, gérés par phpunit. <br>

