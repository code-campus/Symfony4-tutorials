<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/email", name="email")
     */
    public function index(\Swift_Mailer $mailer)
    {    // Définition de l'expéditeur
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
}
