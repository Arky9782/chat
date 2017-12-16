<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04.12.2017
 * Time: 16:45
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\SerializerInterface;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        return new Response('Login successful',200);
    }

}