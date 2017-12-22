<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Chanell
 *
 * @ORM\Table(name="chanell")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChannelRepository")
 */
class Channel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name",type="string")
     */
    private $name;


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Participant", mappedBy="channels")
     */
    private $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


}

