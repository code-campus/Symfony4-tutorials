# Le serveur interne de Symfony 4
> ### Objectifs :
> Installer, démarrer et arrêter le serveur interne de Symfony 4.

# Création d'un nouveau projet

```bash
composer create-project symfony/skeleton my-project
cd my-project
```


# Installer le composant Web Server Bundle

```bash
composer require symfony/web-server-bundle --dev
```


# Démarrer le Serveur Web

```bash
php bin/console server:run
```


# Arrêter le Serveur Web

```bash
php bin/console server:stop
```