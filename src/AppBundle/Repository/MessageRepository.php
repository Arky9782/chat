<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * MessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageRepository extends \Doctrine\ORM\EntityRepository
{
    public function getMessages(EntityManager $em, SerializerInterface $serializer)
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


}
