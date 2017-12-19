<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attachment;
use AppBundle\Entity\Message;
use AppBundle\Repository\Persist;
use AppBundle\Repository\UserRepository;
use AppBundle\Services\FileUploader;
use AppBundle\Services\Flush;
use Doctrine\ORM\EntityManager;
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
    public function getMessagesAction(Flush $flush,EntityManager $em, SerializerInterface $serializer)
    {

        $user = $this->getUser();

        $user->read();
        $em->persist($user);
        $flush();

        $messages = $this->getDoctrine()->getRepository('AppBundle:Message')->getMessages();

        return new JsonResponse($messages);
    }

    /**
     * @Route("/post", name="postMessage")
     *
     *
     * @Method("POST")
     */
    public function postAction(Persist $persist, FileUploader $fileUploader, Flush $flush, SerializerInterface $serializer, Request $request)
    {
        $message = new Message();

        $user = $this->getUser();

        $message->setUser($user);

        if($data = $request->request->get('body'))
        {
            $serializer->deserialize($data, Message::class, 'json', ['object_to_populate' => $message]);
        }

        if($uploadedFile = $request->files->get('file'))
        {
            $path = $fileUploader->getFile($uploadedFile);

            $attachment = new Attachment();

            $attachment->setFile($path);

            $attachment->message($message);

            $persist($attachment);

        }

        $user->addMessage($message);

        $persist($message);

        $flush();

        return new Response(null,201);

    }

}
