<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attachment;
use AppBundle\Entity\Message;
use AppBundle\Repository\Persist;
use AppBundle\Repository\UserRepository;
use AppBundle\Services\FileUploader;
use AppBundle\Services\Flush;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController extends Controller
{

    /**
     * @Route("/messages", name="homepage")
     */
    public function getMessagesAction(Flush $flush,EntityManagerInterface $em, SerializerInterface $serializer)
    {

        $messages = $this->getDoctrine()->getRepository('AppBundle:Message')->getMessages();

        return new JsonResponse($messages);
    }

    /**
     * @Route("/post", name="postMessage")
     *
     *
     * @Method("POST")
     */
    public function postAction(UserRepository $repository, FileUploader $fileUploader, Flush $flush, SerializerInterface $serializer, Request $request)
    {
        $data = $request->getContent();

        $file = $request->files->get('file');

        $string = base64_encode($file);

        $message = new Message();

        $user = $this->getUser();

        $message->setUser($user);

        $serializer->deserialize($data, Message::class, 'json', ['object_to_populate' => $message]);

        $user->addMessage($message);

        $repository->add($message);

        $flush();

        return new Response(null,201);

    }

}
