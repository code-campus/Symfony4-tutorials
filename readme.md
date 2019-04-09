# Le **Maker** de Symfony 4
> ### Objectifs :
> Comprendre et utiliser le Maker de Symfony 4



# Le Maker, qu'est ce que c'est ?

Le Maker est un outil qui permet de créer des commandes vides, des contrôleurs, des classes de formulaire, des tests... afin que les développeurs puissent oublier d’écrire du code standard.



# Création d'un projet 

```bash
composer create-project symfony/website-skeleton my-project
cd my-project
```



# Installer le composant Maker Bundle

```bash
composer require symfony/maker-bundle --dev
```



# Utilisation du Maker

## Obtenir la liste des Makers

```bash
php bin/console list make
```

```bash
make:auth                   Creates a Guard authenticator of different flavors
make:command                Creates a new console command class
make:controller             Creates a new controller class
make:crud                   Creates CRUD for Doctrine entity class
make:entity                 Creates or updates a Doctrine entity class, and optionally an API Platform resource
make:fixtures               Creates a new class to load Doctrine fixtures
make:form                   Creates a new form class
make:functional-test        Creates a new functional test class
make:migration              Creates a new migration based on database changes
make:registration-form      Creates a new registration form system
make:serializer:encoder     Creates a new serializer encoder class
make:serializer:normalizer  Creates a new serializer normalizer class
make:subscriber             Creates a new event subscriber class
make:twig-extension         Creates a new Twig extension class
make:unit-test              Creates a new unit test class
make:user                   Creates a new security user class
make:validator              Creates a new validator and constraint class
make:voter                  Creates a new security voter class
```



# Modifier le Namespace

Par défaut le Namespace d'un projet est `App` (e.g. `App\Entity\Book`).  
Pour modifier le Namespace en `Acme` par exemple, de sorte à obtenir `Acme\Entity\Book`

Créer le fichier de configuration `config/packages/dev/maker.yaml` et y ajouter la configuration :

```yaml
maker:
    root_namespace: 'Acme'
```