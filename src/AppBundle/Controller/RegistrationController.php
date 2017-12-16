<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 28.11.2017
 * Time: 23:42
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Services\Flush;
use AppBundle\Services\Persist;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register")
     */

    public function registerAction(Persist $persist, Flush $flush,Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid())
        {
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $persist($user);
            $flush();

            return new Response('Registration successful',201);

        }

        return $this->render('AppBundle:registration:registration.html.twig',[
            'form' => $form->createView()
        ]);


    }

}