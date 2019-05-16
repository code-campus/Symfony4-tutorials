# C.R.U.D. en WebService
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
- `nelmio/cors-bundle` [Cross-Origin Resource Sharing](https://enable-cors.org/).

## Commandes d'installation

```bash
composer require symfony/flex
composer require symfony/web-server-bundle --dev
composer require symfony/maker-bundle --dev
composer require symfony/orm-pack
composer require symfony/serializer
composer require symfony/property-access
composer require annotations
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



# Créer le contrôleur

```bash
php bin/console make:controller Book
```

La commande à créée le contrôleur `src/Controller/BookController.php` avec la méthode index.
Cette méthode se déclanche avec l'URL http://127.0.0.1:8000/book



# Modifier le contrôleur

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




# Manipuler l'entité

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




# Cross-Origin Resource Sharing

## installation

```bash
composer require nelmio/cors-bundle
```

## Configuration

Modifier la configuration dans le fichier `config/packages/nelmio_cors.yaml`.

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
            allow_headers: ['Content-Type', 'Authorization']
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