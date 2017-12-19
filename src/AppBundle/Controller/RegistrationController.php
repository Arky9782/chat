<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 28.11.2017
 * Time: 23:42
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Repository\Persist;
use AppBundle\Services\Flush;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register")
     */

    public function registerAction(SerializerInterface $serializer, UserPasswordEncoderInterface $passwordEncoder, Persist $persist, Flush $flush, Request $request)
    {
        $user = new User();

        $data = $request->getContent();

        $serializer->deserialize($data,User::class,'json',['object_to_populate' => $user]);

        $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);


        $persist($user);

        $flush();

        return new Response('Registration successful!',201);

    }

}