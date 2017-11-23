<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Repository\MessageRepository;
use AppBundle\Services\Flush;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/messages", name="homepage")
     */
    public function getMessagesAction(SerializerInterface $serializer)
    {
        $repository = $this->getDoctrine()->getRepository(Message::class)
            ->findAll();

        $jsonResponse = $serializer->serialize($repository,'json');

        $response = new JsonResponse();
        $response->setContent($jsonResponse);
        $response->sendContent();

        exit();


    }

    /**
     * @Route("/post", name="postMessage")
     * @Method("POST")
     */
    public function postAction(Flush $flush, SerializerInterface $serializer, Request $request)
    {
        $message = new Message('');

        $data = $request->getContent('body');
        
        $serializer->deserialize($data,Message::class,'json',['object_to_populate' => $message]);

        $flush($message);


        dump($message);

        exit();


    }

}
