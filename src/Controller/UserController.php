<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\RegisterType;
use Carbon\Carbon;

class UserController extends AbstractController
{
  
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        //creando el formulario
        $user = new User();
        $form = $this->createForm(RegisterType::class , $user);
        $form->handleRequest($request);
        // si el fomrulario ha sido enviado
        if( $form->isSubmitted() && $form->isValid() ){
            //modificando objeto para ser  guardado
            $user->setRole('ROLE_USER');
            $user->setCreateAt( Carbon::now()->toDateTime() );
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            //guardar el objeto
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute( 'tasks');
        }
        return $this->render('user/register.html.twig',[ 'form' => $form->createView()]);
    }

    public function login(AuthenticationUtils $authenticationUtils){
           $error = $authenticationUtils->getLastAuthenticationError();
           $lastUserName = $authenticationUtils->getLastUsername();

           return $this->render('user/login.html.twig',[
               'error' => $error,
               'last_username' => $lastUserName
           ]);
    }
}
