<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attachment;
use AppBundle\Entity\Chat_user;
use AppBundle\Entity\Message;
use AppBundle\Repository\MessageRepository;
use AppBundle\Services\FileNameGen;
use AppBundle\Services\Flush;
use AppBundle\Services\PathGen;
use AppBundle\Services\Persist;
use AppBundle\Services\UrlGen;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
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
    public function getMessagesAction(EntityManager $em, SerializerInterface $serializer)
    {
        $dql = "SELECT u.username, a.file, m FROM AppBundle:Message m INNER JOIN m.chatUser u INNER JOIN m.attachment a";
        $query = $em->createQuery($dql)
            ->setFirstResult(0)
            ->setMaxResults(20);

        $paginator = new Paginator($query, $fetchJoinCollection = true);
        $c = count($paginator);

        foreach ($paginator as $messages) {

            $arr[] = $jsonResponse = $serializer->serialize($messages, 'json');
        }

        return new JsonResponse($arr);

    }

    /**
     * @Route("/post", name="postMessage")
     *
     *
     * @Method("POST")
     */
    public function postAction(UrlGen $urlGen, FileNameGen $fileNameGen, Persist $persist, Flush $flush, SerializerInterface $serializer, Request $request)
    {
        $message = new Message();

        $user = $this->getUser();

        $message->setUser($user);

        if($data = $request->request->get('body'))
        {
            $serializer->deserialize($data, Message::class, 'json', ['object_to_populate' => $message]);
        }

        if($uploadedFile = $request->files->get('file')) {

            $fileName = $fileNameGen->genFileName();

            $URL = $urlGen->genUrl().$fileName;

            $uploadedFile->move('files_directory', $fileName);

            $attachment = new Attachment();

            $attachment->setFile($URL);

            $attachment->message($message);

            $persist($attachment);

        }

        $user->addMessage($message);

        $persist($message);

        $flush();

        return new Response(null,201);

    }

}
