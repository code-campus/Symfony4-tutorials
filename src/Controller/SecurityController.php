<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route( "/api", name="security:api" )
 */
class SecurityController extends AbstractController
{
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
            "id" => $user->getId(),
            "firstname" => $user->getFirstname(),
            "lastname" => $user->getLastname(),
            "email" => $user->getEmail()
        ]);
    }

    /**
     * @Route(
     *      "/profile", 
     *      name=":profile", 
     *      methods={"GET"}
     * )
     */
    public function profile(Request $request)
    {
        return $this->json( $this->getUser() );
    }

    /**
     * @Route(
     *      "/forgotten-password", 
     *      name=":forgottenPassword", 
     *      methods={"POST"}
     * )
     */
    public function forgottenPassword(Request $request)
    {
        // Retrieve Registration data
        $data = \json_decode($request->getContent(), true);

        return $this->json( $data );
    }

    /**
     * @Route(
     *      "/renew-password", 
     *      name=":renewPassword", 
     *      methods={"POST"}
     * )
     */
    public function renewPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // Retrieve Registration data
        $data = \json_decode($request->getContent(), true);
        $user = $this->getUser();

        $passwordOld = $data['passwordOld'];
        $passwordNew = $data['passwordNew'];
        $passwordConfirmation = $data['passwordConfirmation'];

        // Si l'ancien mot de passe est correct
        if ($passwordEncoder->isPasswordValid($user, $passwordOld) && $passwordNew == $passwordConfirmation)
        {
            $newEncodedPassword = $passwordEncoder->encodePassword($user, $passwordNew);
            $user->setPassword($newEncodedPassword);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->json( [$passwordOld, $passwordNew, $passwordConfirmation, $user] );
    }
}
