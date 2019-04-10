# Création d'un projet Symfony 4
> ### Objectifs :
> Créer un C.R.U.D. simple avec API Platform



# Création d'un nouveau projet

```bash
composer create-project symfony/skeleton my-project
cd my-project
```



# Installation des dépendances

## Liste des dépendances
- `symfony/flex`
- `symfony/web-server-bundle` permet de controler le serveur interne de PHP.
- `symfony/maker-bundle` permet de créer un controleur.
- `symfony/orm-pack` permet de créer et gérer la base de données.
- `annotations` permet de créer une route en annotation dans notre controleur.
- `api` API Platform.


## Commandes d'installation

```bash 
composer require symfony/flex
composer require symfony/web-server-bundle --dev
composer require symfony/maker-bundle --dev
composer require symfony/orm-pack
composer require annotations
composer require api
```



# Démarrer le serveur Symfony

```bash
php bin/console server:run
```

Aller à l'adresse `http://127.0.0.1:8000/api` pour constater le fonctionnement du bundle API Platform.



# Base de données

## Configuration
Dans le fichier `.env`, modifier la ligne :

```bash
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
```

- **mysql** : Définit le type de SGBD.
- **db_user** : Définit le nom d'utilisateur.
- **db_password** : Définit le mon de passe.
- **127.0.0.1** : Définit l'adresse du serveur.
- **3306** : Définit le port.
- **db_name** : Définit le nom du schéma.


## Création
```bash
php bin/console doctrine:database:create
```



# Créer une entité

## Créer l'entité

```bash 
php bin/console make:entity Book
```

## Ajouter les propriété
- **title** :
    - type : string
    - length : 255
    - nullable : no
- **description** :
    - type : text
    - nullable : yes
- **price** :
    - type : float
    - nullable : no

## Mise à jour de la base de données

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```



# Rendre l'entité accessible via l'API

## Aperçu des routes

```bash
php bin/console debug:router
> api_entrypoint       ANY      ANY      ANY    /api/{index}.{_format}
> api_doc              ANY      ANY      ANY    /api/docs.{_format}
> api_jsonld_context   ANY      ANY      ANY    /api/contexts/{shortName}.{_format}
```


## Modifier l'entité

### Ajouter la dépendance

```php
use ApiPlatform\Core\Annotation\ApiResource;
```

### Ajouter l'annotation ApiResource

```php
/**
 * @ApiResource
 * @ORM\Entity
 */
class Book {
    // ...
}
```

Executer à nouveau la commande `php bin/console debug:router` pour constater que le C.R.U.D. de l'entité est accessible via l'API.



# Manipuler l'entité

## Liste des entrées

Equivalent de la méthode `index` de la commande `make:crud`

```bash
curl -X GET http://127.0.0.1:8000/api/books.json
```


## Ajouter une entrée

Equivalent de la méthode `new` de la commande `make:crud`

```bash
curl -X POST http://127.0.0.1:8000/api/books.json -H "Content-Type: application/json" -d {"title": "Un super livre", "description": "lorem ipsum blabla...", "price": 9.99}
```


## Affiché le détail d'une entrée

Equivalent de la méthode `show` de la commande `make:crud`

```bash
curl -X GET http://127.0.0.1:8000/api/books/{id}.json -d id=42
```


## Modifier une entrée

Equivalent de la méthode `edit` de la commande `make:crud`

```bash
curl -X PUT http://127.0.0.1:8000/api/books/{id}.json -H "Content-Type: application/json" -d {"title": "Azerty"}
```


## Supprimer une entrée

Equivalent de la méthode `delete` de la commande `make:crud`

```bash
curl -X DELETE http://127.0.0.1:8000/api/books/{id}.json -d id=42
```


