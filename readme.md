# Créer un contrôleur
> ### Objectifs :
> Savoir créer un contrôleur et déclencher une action avec une route


# Création d'un nouveau projet

```bash
composer create-project symfony/skeleton my-project
cd my-project
```


# Installation des dépendances

## Liste des dépendances

- `symfony/web-server-bundle` permet de controler le serveur interne de PHP.
- `symfony/maker-bundle` permet de créer un contrôleur.
- `annotations` permet de créer une route en annotation dans notre controleur.


## Commandes d'installation

```bash
composer require symfony/web-server-bundle --dev
composer require symfony/maker-bundle --dev
composer require annotations
```


# Créer un contrôleur

```bash
php bin/console make:controller Book
```

La commande à créée le contrôleur `src/Controller/BookController.php` avec la méthode `index`.  
Cette méthode se déclanche avec l'URL `http://127.0.0.1:8000/book`