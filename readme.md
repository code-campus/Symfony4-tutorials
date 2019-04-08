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
php bin/console server:start
```

```bash
php bin/console server:run
```

Définir une adresse static

```bash
php bin/console server:start 192.168.0.1:8080
```


# Arrêter le Serveur Web

```bash
php bin/console server:stop
```