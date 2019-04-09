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
- `annotations` permet de créer une route en annotation dans notre controleur.

## Commandes d'installation

```bash
composer require symfony/flex
composer require symfony/web-server-bundle --dev
composer require symfony/maker-bundle --dev
composer require annotations
```