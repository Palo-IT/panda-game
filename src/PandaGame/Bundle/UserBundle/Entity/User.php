<?php

namespace PandaGame\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Accessor;

/**
 * PandaGame\Bundle\UserBundle\Entity\User
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @var int $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $username
     *
     * @Groups({"list", "details"})
     */
    protected $username;

    /**
     * @var string $usernameCanonical
     *
     * @Groups({"list", "details"})
     */
    protected $usernameCanonical;

    /**
     * @var string $content
     *
     * @ORM\Column(name="avatar", type="string", nullable=false)
     *
     * @Groups({"list", "details"})
     * @Accessor(getter="getLogoWebPath", setter="setLogo")
     */
    private $avatar = 'default.png';

    /**
     * @var ArrayCollection $score
     *
     * @ORM\OneToMany(targetEntity="PandaGame\Bundle\ScoreBundle\Entity\Score", mappedBy="user", indexBy="id")
     */
    private $scores;

    public function __construct()
    {
        parent::__construct();

        $this->scores = new ArrayCollection();
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
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return string
     */
    public function getAvatarWebPath()
    {
        return 'http://' . $this->getAvatarAbsoluteDir() . '/' . $this->getAvatar();
    }

    /**
     * Get the avatar absolute directory
     *
     * @return string
     */
    public function getAvatarAbsoluteDir()
    {
        return rtrim($_SERVER['HTTP_HOST'], '/') . "/" . $this->getAvatarWebDir();
    }

    /**
     * @return string
     */
    private function getAvatarWebDir()
    {
        return 'files/user/avatar';
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $scores
     *
     * @return $this
     */
    public function setScores($scores)
    {
        $this->scores = $scores;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return is_null($this->getId());
    }
}