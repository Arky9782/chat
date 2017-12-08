<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 28.11.2017
 * Time: 23:42
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Chat_user;
use AppBundle\Form\UserType;
use AppBundle\Services\Flush;
use AppBundle\Services\Persist;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Tests\Fixtures\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register")
     */

    public function registerAction(Persist $persist, Flush $flush,Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new Chat_user();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid())
        {
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $persist($user);
            $flush();

            return 'Registration successful';

        }

        return $this->render('AppBundle:registration:registration.html.twig',[
            'form' => $form->createView()
        ]);


    }

}