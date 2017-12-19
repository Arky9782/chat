<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 18.12.2017
 * Time: 21:57
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityManagerInterface;

class Persist
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function __invoke($data)
    {
        $this->em->persist($data);
    }
}