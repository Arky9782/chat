<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 01.12.2017
 * Time: 22:51
 */

namespace AppBundle\Services;


use Doctrine\ORM\EntityManager;

final class Persist
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __invoke($data)
    {
        $this->em->persist($data);
    }

}