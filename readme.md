# C.R.U.D.
> ### Objectifs :
> Savoir créer un CRUD rapidement avec Symfony



# Création d'un nouveau projet

```bash
composer create-project symfony/skeleton my-project
cd my-project
```



# Installation des dépendances

## Liste des dépendances
- `symfony/flex`
- `symfony/web-server-bundle` permet de controler le serveur interne de PHP.
- `symfony/maker-bundle` permet de créer un controleur.
- `symfony/orm-pack` permet de créer et gérer la base de données.
- `annotations` permet de créer une route en annotation dans notre controleur.

## Commandes d'installation

```bash
composer require symfony/flex
composer require symfony/web-server-bundle --dev
composer require symfony/maker-bundle --dev
composer require symfony/orm-pack
composer require annotations
composer require form
composer require validator
composer require twig-bundle
composer require security-csrf
```



# Démarrer le serveur Symfony

```bash
php bin/console server:run
```



# Base de données

## Configuration

Dans le fichier `.env`, modifier la ligne :

```yaml
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



# Créer le C.R.U.D.

```bash
php bin/console make:crud Book
```

La commande va créer :

- Le controller 
    - `src/Controller/BookController.php`
- Le type 
    - `src/Form/BookType.php` 
- Les vues
    - `templates/book/_delete_form.html.twig`
    - `templates/book/_form.html.twig`
    - `templates/book/edit.html.twig`
    - `templates/book/index.html.twig`
    - `templates/book/new.html.twig`
    - `templates/book/show.html.twig`



# Tester le C.R.U.D.

Aller à l'adresse `http://127.0.0.1:8000/book/`