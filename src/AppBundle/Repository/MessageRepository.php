<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Query\AST\Functions\IdentityFunction;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;


/**
 * MessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageRepository extends \Doctrine\ORM\EntityRepository
{
    private $em;

    public function __construct(EntityManager $em, Mapping\ClassMetadata $class)
    {
        $this->em = $em;
        parent::__construct($em, $class);
    }

    public function getMessages()
    {
        $querybuilder = $this->em->createQueryBuilder()
            ->select('m.body','m.createdAt','m.id', 'a.file', 'u.username','u.channels')
            ->from('AppBundle:Message','m')
            ->innerJoin('m.User','u')
            ->innerJoin('m.attachment','a')
            ->setMaxResults(50)
            ->setFirstResult(0);

        $paginator = new Paginator($querybuilder, $fetchJoinCollection = true);
        $paginator->setUseOutputWalkers(false);

        $arr = [];
        foreach ($paginator as $result) {
            $arr[] = $result;
        }

        return $arr;

    }

    public function persist($data)
    {
        $this->em->persist($data);
    }


}
