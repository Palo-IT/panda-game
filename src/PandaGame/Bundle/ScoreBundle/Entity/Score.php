<?php

namespace PandaGame\Bundle\ScoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;

/**
 * PandaGame\Bundle\ScoreBundle\Entity\Score
 *
 * @ORM\Entity
 * @ORM\Table(name="score")
 */
class Score
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups({"list", "details"})
     */
    private $id;

    /**
     * @var int $date
     *
     * @ORM\Column(name="result", type="integer", nullable=false)
     * @Assert\NotNull()
     * @Assert\Type(type="integer")
     *
     * @Groups({"list", "details"})
     */
    private $result;

    /**
     * @var \DateTime $date
     *
     * @ORM\Column(name="creation", type="datetime", nullable=false)
     * @Assert\NotNull()
     * @Assert\Date()
     *
     * @Groups({"list", "details"})
     */
    private $creation;

    /**
     * @var \PandaGame\Bundle\UserBundle\Entity\User $user
     *
     * @ORM\ManyToOne(targetEntity="PandaGame\Bundle\UserBundle\Entity\User", inversedBy="scores")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @Assert\NotNull()
     * @Assert\Type(type="PandaGame\Bundle\UserBundle\Entity\User")
     *
     * @Groups({"list", "details"})
     */
    private $user;

    public function __construct()
    {
        $this->setCreation(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $creation
     *
     * @return $this
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * @param int $result
     *
     * @return $this
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param \PandaGame\Bundle\UserBundle\Entity\User $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \PandaGame\Bundle\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}