<?php

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
    
        // if (!$user instanceof UserInterface) {
        //     return;
        // }
    
        // $data['data'] = array(
        //     'email' => $user->getEmail(),
        //     // 'roles' => $user->getRoles(),
        // );

        $data['id'] = $user->getId();
        $data['firstname'] = $user->getFirstname();
        $data['lastname'] = $user->getLastname();
        $data['email'] = $user->getEmail();
    
        $event->setData($data);
    }
}
