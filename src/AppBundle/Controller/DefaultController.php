<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Repository\MessageRepository;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/messages", name="homepage")
     */
    public function getMessagesAction()
    {
        $repository = $this->getDoctrine()->getRepository(Message::class)
            ->findAll();


        $normalizer = [new ObjectNormalizer()];
        $encoder = [new JsonEncoder()];
        $serializer = new Serializer($normalizer, $encoder);

        $jsonResponse = $serializer->serialize($repository,'json');

        echo $jsonResponse;

        exit();
    }

    /**
     * @Route("/post", name="postMessage")
     * @Method("POST")
     */
    public function postAction(Request $request, EntityManager $em)
    {
        $message = new Message();
        $message->setBody('');
        $message->setCreatedAt();

        $data = $request->getContent();

        $normalizer = [new ObjectNormalizer()];
        $encoder = [new JsonEncoder()];
        $serializer = new Serializer($normalizer, $encoder);

        $serializer->deserialize($data,Message::class,'json',['object_to_populate' => $message]);

        $em->persist($message);
        $em->flush();


        dump($message);

        exit();


    }

}
