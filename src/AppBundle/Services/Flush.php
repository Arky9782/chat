<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 23.11.2017
 * Time: 13:21
 */

namespace AppBundle\Services;


use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

final class Flush
{
    private $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function __invoke($data)
    {
        $this->em->persist($data);
        $this->em->flush();
    }
}