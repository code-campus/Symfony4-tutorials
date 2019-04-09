# Créer une entité
> ### Objectifs :
> Savoir créer une entité, l'ajouter à la base de données et manipuler l'entité.



# Création d'un nouveau projet

```bash
composer create-project symfony/skeleton my-project
cd my-project
```



# Installation des dépendances

## Liste des dépendances

- `symfony/flex`
- `symfony/web-server-bundle` permet de controler le serveur interne de PHP.
- `symfony/maker-bundle` permet de créer un contrôleur.
- `symfony/orm-pack` permet de créer et gérer la base de données.
- `annotations` permet de créer une route en annotation dans notre controleur.

## Commandes d'installation

```bash
composer require symfony/flex
composer require symfony/web-server-bundle --dev
composer require symfony/maker-bundle --dev
composer require symfony/orm-pack
composer require annotations
```



# Démarrer le serveur Symfony

```bash
php bin/console server:run
```



# Base de données

## Configuration

Dans le fichier .env, modifier la ligne :

```yaml
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
```

- mysql : Définit le type de SGBD.
- db_user : Définit le nom d'utilisateur.
- db_password : Définit le mon de passe.
- 127.0.0.1 : Définit l'adresse du serveur.
- 3306 : Définit le port.
- db_name : Définit le nom du schéma.


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