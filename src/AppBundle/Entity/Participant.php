<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Participant
 *
 * @ORM\Table(name="participant")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParticipantRepository")
 */
class Participant
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
     * @var \DateTime
     *
     * @ORM\Column(name="readAt", type="datetime", nullable=true)
     */
    private $readAt;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="participants")
     * @ORM\JoinTable(name="users_participants")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Channel", inversedBy="participants")
     * @ORM\JoinColumn(name="channels_participants")
     */
    private $channels;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    /**
     * Set readAt
     *
     * @param \DateTime $readAt
     *
     * @return Participant
     */
    public function setReadAt($readAt)
    {
        $this->readAt = $readAt;

        return $this;
    }

    /**
     * Get readAt
     *
     * @return \DateTime
     */
    public function getReadAt()
    {
        return $this->readAt;
    }
}

