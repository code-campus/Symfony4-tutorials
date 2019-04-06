# Envoyer des emails avec SwiftMailer
> ### Objectifs :
> Savoir envoyer des emails au format HTML et/ou texte avec pièce jointe
> Documentation : https://swiftmailer.symfony.com/ 


# Création d'un nouveau projet

```bash
composer create-project symfony/skeleton my-project
cd my-project
```


# Installation des dépendances

## Liste des dépendances

- `symfony/web-server-bundle` permet de controler le serveur interne de PHP.
- `symfony/maker-bundle` permet de créer un controleur.
- `annotations` permet de créer une route en annotation dans notre controleur.
- `symfony/swiftmailer-bundle` gère l'envois des emails.
- `symfony/twig-bundle` permet de créer des vues HTML et TXT.

## Commandes d'installation

```bash
composer require symfony/web-server-bundle --dev
composer require symfony/maker-bundle --dev
composer require annotations
composer require symfony/swiftmailer-bundle
composer require symfony/twig-bundle
```


# Démarrer le serveur Symfony

```bash
php bin/console server:run
```


# Configuration

## Avec un serveur SMTP OVH

Ajouter les paramètres de configuration dans le fichier `.env` :

```yaml
MAILER_TRANSPORT=smpt
MAILER_AUTHMODE=login
MAILER_HOST=ssl0.ovh.net
MAILER_USERNAME=YOUR_USERNAME
MAILER_PASSWORD=YOUR_PASSWORD
MAILER_PORT=587
```

> Remplacer `YOUR_USERNAME` par l'adresse email et `YOUR_PASSWORD` par le mot de passe qui lui est associé.

Récupérer les paramètres de configuration dans le fichier `config/packages/swiftmailer.yaml` :

```yaml
swiftmailer:
    transport:  '%env(MAILER_TRANSPORT)%'
    auth_mode:  '%env(MAILER_AUTHMODE)%'
    host:       '%env(MAILER_HOST)%'
    username:   '%env(MAILER_USERNAME)%'
    password:   '%env(MAILER_PASSWORD)%'
    port:       '%env(MAILER_PORT)%'
    spool:      { type: 'memory' }
```

<!-- ## Avec une adresse **gMail** -->
<!-- TODO -->


# Création du contrôleur

## Créer le contrôleur

```bash
php bin/console make:controller EmailController
``` 

Le maker créer le fichier `src/Controller/EmailController.php`

```php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/email", name="email")
     */
    public function index()
    {
        // ...
    }
}
```

## Modifier la méthode

```php
public function index(\Swift_Mailer $mailer)
{
    // Définition de l'expéditeur
    // --
    // Peut être une chaine ou un tableau
    // $sender = "john@doe.com";
    $from = [ "john@doe.com" => "John Doe" ];

    
    // Définition du destinataire
    // --
    // Peut être une chaine ou un tableau
    // $to = "jane@doe.com";
    $to = ["jane@doe.com" => "Jane Doe"];
    // $to = ["jane@doe.com" => "Jane Doe", "bruce@wayne.com" => "Bruce Wayne"];

    
    // Définition du sujet du mail
    // --
    $subject = "This is the email subject";


    // Définition des paramètres de personnalisation du message
    // --
    $data = [
        'subject'   => $subject,
        'firstname' => "Bruce",
        'lastname'  => "WAYNE",
        'email'     => "bruce@wayne.com"
    ];


    // Définition d'une piéce jointe
    // -- 
    // $attachment = \Swift_Attachment::fromPath(
    //     '/path/to/image.jpg', 
    //     'image/jpeg'
    // );


    // Définition du message
    // --

    // Création du message
    $message = new \Swift_Message();

    // Le sujet du message
    $message->setSubject( $subject );

    // L'epéditeur du message
    $message->setFrom( $from );

    // Le(s) destinataire(s) du message
    $message->setTo( $to );
    // $message->setCc( ... );
    // $message->setBcc( ... );

    // Ajouter des destinataires
    // $message->addTo( 'person@example.org', 'Person Name' );
    // $message->addCc( ... );
    // $message->addBcc( ... );

    // Le message principal (au format HTML)
    $message->setBody(
        $this->renderView(
            "email/index.html.twig", 
            $data
        ), 
        'text/html'
    );

    // Le message alternatif (au format TXT)
    $message->addPart(
        $this->renderView(
            "email/index.txt.twig", 
            $data
        ), 
        'text/plain'
    );

    // Ajout de la pièce jointe
    // $message->attach($attachment);


    // Envois du message
    // --
    $sent = $mailer->send($message);


    return $this->json([
        'subject'   => $data['subject'],
        'is sent ?' => $sent ? "yes" : "no",
        'path'      => 'src/Controller/EmailController.php',
    ]);
}
```

## Créer la vue HTML

Le fichier de la vue HTML est `templates/email/index.html.twig`

```html
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>{{ subject }}</title>
    </head>
    <body>
        <h1>{{ subject }}</h1>
        <p>Welcome {{ firstname }},</p>
        <p>This is a test of an HTML Email Version.</p>
        <p>Your email address is : {{ email }}</p>
    </body>
</html>
```

## Créer la vue TEXT

Le fichier de la vue TEXT est `templates/email/index.txt.twig`

```text
{{ subject }}

Welcome {{ firstname }},
This is a test of a TEXT Email Version.
Your email address is : {{ email }}
```


# Memo

Afficher la configuration par défaut de swiftmailer :

```bash
php bin/console config:dump-reference swiftmailer
```

Afficher la configuration de l’application :

```bash
php bin/console debug:config swiftmailer
```