# C.R.U.D. en WebService et controle d'accès
> ### Objectifs :
> Créer et gérer une entité (crud) en Web Service.



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
- `symfony/serializer`
- `annotations` permet de créer une route en annotation dans notre controleur.
- `security`
- `lexik/jwt-authentication-bundle`

## Commandes d'installation

```bash
composer require symfony/flex
composer require symfony/web-server-bundle --dev
composer require symfony/maker-bundle --dev
composer require symfony/orm-pack
composer require symfony/serializer
composer require symfony/property-access
composer require annotations
composer require security
composer require lexik/jwt-authentication-bundle
composer require nelmio/cors-bundle
```



# Démarrer le serveur Symfony

```bash
php bin/console server:run
```



# Base de données

## Configuration

Dans le fichier `.env`, modifier la ligne :

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



# L'entité `book`

## Création de l'entité

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



# Créer le contrôleur Book

```bash
php bin/console make:controller Book
```

La commande à créée le contrôleur `src/Controller/BookController.php` avec la méthode index.
Cette méthode se déclanche avec l'URL http://127.0.0.1:8000/book



# Modifier le contrôleur Book

Modifier le fichier `src/Controller/BookController.php`

## Ajouter les dépendances

```php
use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
```


## Ajouter le préfix de route

```php
/**
 * @Route("/api", name="books:api")
 */
class BookController extends AbstractController {}
```




# Manipuler l'entité Book

## Liste des entrées

```php
/**
 * @Route("/books.json", name=":index", methods={"GET"})
 */
public function index(BookRepository $bookRepository): Response
{
    return $this->json( $bookRepository->findAll() );
}
```


## Ajouter une entrée

```php
/**
 * @Route("/books.json", name=":new", methods={"POST"})
 */
public function new(Request $request): Response
{
    $book = new Book();

    $data = \json_decode($request->getContent(), true);

    foreach ($data as $key => $value)
    {
        $property = ucfirst($key);
        $property = 'set'.$property;

        $book->$property($value);
    }

    $em = $this->getDoctrine()->getManager();
    $em->persist($book);
    $em->flush();

    return $this->json( $book );
}
```


## Affiché le détail d'une entrée

```php
/**
 * @Route("/books/{id}.json", name="show", methods={"GET"})
 */
public function show(Book $book): Response
{
    return $this->json( $book );
}
```


## Modifier une entrée

```php
/**
 * @Route("/books/{id}.json", name="edit", methods={"PUT"})
 */
public function edit(Request $request, Book $book): Response
{
    $data = \json_decode($request->getContent(), true);

    foreach ($data as $key => $value)
    {
        $property = ucfirst($key);
        $property = 'set'.$property;

        $book->$property($value);
    }

    $this->getDoctrine()->getManager()->flush();

    return $this->json( $book );
}
```


## Supprimer une entrée

```php
/**
 * @Route("/books/{id}.json", name="delete", methods={"DELETE"})
 */
public function delete(Request $request, Book $book): Response
{
    $bookID = $book->getId();

    $em = $this->getDoctrine()->getManager();
    $em->remove($book);
    $em->flush();

    return $this->json([
        "message" => "Entity ID : ". $bookID ." is deleted"
    ]);
}
```



# L'entité `user`

## Création de l'entité
```bash
php bin/console make:user
```

Valider, sans modification, les suggestions du terminal

```bash
> The name of the security user class [User]:
> Do you want to store user data in the database (via Doctrine)? [yes]:
> Enter a property name that will be the unique "display" name for the user [email]:
> Does this app need to hash/check user passwords? [yes]:
```

## Ajouter des propriétés de l'entité

```bash
php bin/console make:entity User
```

Ajouter les propriété :

- **firstname** : Prénom de l'utilisateur
    - type : string
    - length : 40
    - nullable : no
- **lastname** : Nom de l'utilisateur
    - type : string
    - length : 40
    - nullable : no
- **fullname** : Nom complet de l'utilisateur
    - type : string
    - length : 90
    - nullable : yes
- **isActive** : Indicateur d’activation du compte
    - type : boolean
    - nullable : no
- **pwdToken** : Token de restauration du mot de passe
    - type : string
    - length : 255
    - nullable : yes


## Modifier l'entité

Dans le fichier `src/Entity/User.php`, modifier la ligne :

```php
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface {}

/**
 * @ORM\Column(type="boolean")
 */
private $isActive = false;

// ...
/**
 * @ORM\PrePersist
 */
public function setFullname(): self
{
    $this->fullname = $this->firstname;
    $this->fullname.= ' ';
    $this->fullname.= substr($this->lastname, 0, 1).".";

    return $this;
}
```

## Mise à jour de la base de données

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```



# JWT Authentication Bundle

GitHub : https://github.com/lexik/LexikJWTAuthenticationBundle

## Installation de la dépendance

### Installer la dépendance

```bash
composer require lexik/jwt-authentication-bundle
```

### Ajouter le namespace de la dépendance au registre de Symfony

Modifier le fichier config/bundles.php

```php
Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle::class => ['all' => true],
```

## Générer les clés SSH

**/!\ pass phrase** : Voir la variable `JWT_PASSPHRASE` du fichier `.env`

```bash
mkdir -p config/jwt
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

## Configuration de la dépendance

Modifier la configuration dans le fichier `config/packages/lexik_jwt_authentication.yaml`

Configuration par défaut : https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/1-configuration-reference.md#full-default-configuration

Configuration minimum :

```yaml
lexik_jwt_authentication:
    secret_key: '%env(resolve:JWT_SECRET_KEY)%'
    public_key: '%env(resolve:JWT_PUBLIC_KEY)%'
    pass_phrase: '%env(JWT_PASSPHRASE)%'
```

## Configuration des Firewall et Contrôle d'accès

Modifier la configuration dans le fichier `config/packages/security.yaml`

```yaml
security:
    # ...
    
    firewalls:

        api:
            pattern: ^/api
            provider: app_user_provider
            stateless: true
            anonymous: false
            guard:
                authenticators:
                    - lexik_jwt_authentication.jwt_token_authenticator

    access_control:
        - { path: ^/api,            roles: IS_AUTHENTICATED_FULLY }
```

## Personnaliser la réponse de JWT Authentication Bundle

Par défaut, lorsque la connexion est réussie, JWT Authentication Bundle ne retourne que le token.  
Il est souvent utilie de recevoir d'autres informations liées à l'utilisateur.

### Créer le Listener 

Créer le fichier `src/EventListener/AuthenticationSuccessListener.php`.

```php
namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {

        $data = $event->getData();
        $user = $event->getUser();

        // Add custom data
        $data['id'] = $user->getId();
        $data['firstname'] = $user->getFirstname();
        $data['lastname'] = $user->getLastname();
        $data['email'] = $user->getEmail();
    
        $event->setData($data);
    }
}
```

### Déclarer le Listener

Déclarer le `Listener` dans le fichier `config/services.yaml`.

```yaml
services:
    App\EventListener\AuthenticationSuccessListener:
        tags:
            - { name: kernel.event_listener, event: lexik_jwt_authentication.on_authentication_success, method: onAuthenticationSuccessResponse }
```



# Création du contrôleur security

## Créer le contrôleur

```bash
php bin/console make:controller SecurityController
```

## Modifier le contrôleur

Modifier le fichier `src/Controller/SecurityController.php` 

```php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route( "/api", name="security:api" )
 */
class SecurityController extends AbstractController
{
}
```



# Ajout d'un utilisateur : register

## Configurer le Firewall

Ajouter le firewall au fichier `config/packages/security.yaml`

**Attention** : Ajouter le firewall register avant le firewall api

```yaml
security:
    # ...
    firewalls:

        register:
            pattern:  ^/api/register
            stateless: true
            anonymous: true
```


## Modifier le contrôle d'accès

Ajouter le contrôle d'accès au fichier `config/packages/security.yaml`

```yaml
security:
    # ...

    access_control:
        - { path: ^/api/register,   roles: IS_AUTHENTICATED_ANONYMOUSLY }
        # ...
```


## Modifier le contrôleur

Modifier le fichier `src/Controller/SecurityController.php`

### Ajout des dépendances

```php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
```

### Ajout de la méthode register

```php
/**
 * @Route(
 *      "/register", 
 *      name=":register", 
 *      methods={"POST"}
 * )
 */
public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
{
    $user = new User();

    // Retrieve Registration data
    $data = \json_decode($request->getContent(), true);

    $firstname          = $data['firstname'];
    $lastname           = $data['lastname'];
    $email              = $data['email'];
    $plain_password     = $data['password'];
    $encoded_password   = $passwordEncoder->encodePassword($user, $plain_password);

    $user->setFirstname($firstname);
    $user->setLastname($lastname);
    $user->setEmail($email);
    $user->setPassword($encoded_password);
    
    $em = $this->getDoctrine()->getManager();
    $em->persist($user);
    $em->flush();

    return $this->json([
        json_decode($request->getContent()),
        "id" => $user->getId(),
        "firstname" => $user->getFirstname(),
        "lastname" => $user->getLastname(),
        "email" => $user->getEmail()
    ]);
}
```


## Test de la requete
```bash
curl -X POST http://127.0.0.1:8000/api/register -H "Content-Type: application/json" -d '{ "firstname": "John", "lastname": "DOE", "email": "john@doe.com", "password": "123456" }'
```



# Connexion d'un utilisateur : login

## Configurer le Firewall

Ajouter le firewall au fichier `config/packages/security.yaml`

**Attention** : Ajouter le firewall login avant le firewall api

```yaml
security:
    # ...
    firewalls:

        login:
            pattern:   ^/api/login
            stateless: true
            anonymous: true
            provider: app_user_provider
            json_login:
                check_path: /api/login
                username_path: email
                password_path: password
                success_handler: lexik_jwt_authentication.handler.authentication_success
                failure_handler: lexik_jwt_authentication.handler.authentication_failure
```


## Modifier le contrôle d'accès

Ajouter le contrôle d'accès au fichier `config/packages/security.yaml`

```yaml
security:
    # ...

    access_control:
        - { path: ^/api/login,      roles: IS_AUTHENTICATED_ANONYMOUSLY }
        # ...
```


## Définir la route

Ajouter la route au fichier `config/routes.yaml`

```yaml
secutity:api:login:
    path: /api/login
    methods: POST
```


## Test de la requete

```bash
curl -X POST http://127.0.0.1:8000/api/login -H "Content-Type: application/json" -d '{ "email": "john@doe.com", "password": "123456" }'
> {"token": "..."}
```



# Cross-Origin Resource Sharing

## installation

```bash
composer require nelmio/cors-bundle
```

## Configuration

Modifier la configuration dans le fichier config/packages/nelmio_cors.yaml.

```yaml
nelmio_cors:
    defaults:
        origin_regex: true
        allow_origin: ['%env(CORS_ALLOW_ORIGIN)%']
        allow_methods: ['GET', 'OPTIONS', 'POST', 'PUT', 'PATCH', 'DELETE']
        allow_headers: ['Content-Type', 'Authorization']
        expose_headers: ['Link']
        max_age: 3600
    paths:
        # https://site.com/api/...
        '^/api/':
            allow_origin: ['*']
            allow_headers: ['X-Custom-Auth']
            allow_methods: ['POST', 'PUT', 'GET', 'DELETE']
            max_age: 3600
        # https://api.site.com/...
        # '^/':
        #     origin_regex: true
        #     allow_origin: ['^http://localhost:[0-9]+']
        #     allow_headers: ['X-Custom-Auth']
        #     allow_methods: ['POST', 'PUT', 'GET', 'DELETE']
        #     max_age: 3600
        #     hosts: ['^api\.']
```