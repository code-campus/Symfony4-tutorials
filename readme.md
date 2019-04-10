# Créer une commande pour la console
> ### Objectifs :
> Savoir créer et utiliser une commande pour la console Symfony



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
<!-- annotations permet de créer une route en annotation dans notre controleur. -->


## Commandes d'installation
composer require symfony/flex
composer require symfony/web-server-bundle --dev
composer require symfony/maker-bundle --dev
<!-- composer require annotations -->



# Créer une commande

```bash
php bin/console make:command Date
```

La commande va créer le fichier `src/Command/DateCommand.php`

La commande s'exécute avec l'instruction :

```bash
php bin/console Date
```



# Modifier la commande

Dans le fichier `src/Command/DateCommand.php`


## Préfixer / Modifier le nom de la commande

Modifier la ligne :

```php
protected static $defaultName = 'app:date';
```

La commande s'exécute avec l'instruction :

```bash
php bin/console app:date
> retourne la date du jour
```


## Modifier la description de la commande

La description de la commande apparait dans la liste des commandes disponible.

Dans la méthode `configure`, Ajouter la ligne :

```php
protected function configure()
{
    $this
        ->setDescription('Add a short description for your command')
    ;
}
``` 


## Passer des arguments

Dans la méthode `configure`, Ajouter la ligne :

```php
protected function configure()
{
    $this
        ->addArgument('param_1', 'param_2', 'param_3')
    ;
}
``` 

- **param_1** chaine de caractère qui représente le nom de l'argument
- **param_2** constante de la classe `InputArgument` qui définie si l'argument est obligatoire ou optionnel
- **param_3** chaine de caractère qui représente la description de l'argument

La commande s'exécute avec l'instruction :

```bash
php bin/console app:date tomorrow
> retourne la date de demain
```


## Passer des options

// ...


## Sortie de la commande

// ...



# Memo

Obtenir la liste des commandes

```bash
php bin/console list
``` 