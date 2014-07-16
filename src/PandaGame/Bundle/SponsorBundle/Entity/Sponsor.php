<?php

namespace PandaGame\Bundle\SponsorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Accessor;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * PandaGame\Bundle\SponsorBundle\Entity\Sponsor
 *
 * @ORM\Entity
 * @ORM\Table(name="sponsor")
 * @UniqueEntity("name")
 */
class Sponsor
{
    const TYPE_BRONZE   = 1;
    const TYPE_SILVER   = 2;
    const TYPE_GOLD     = 3;
    const TYPE_PLATINUM = 4;

    const STATUS_INACTIVE    = 0;
    const STATUS_ACTIVE      = 1;
    const STATUS_TO_VALIDATE = 2;

    /**
     * @var int $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups({"list", "details"})
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     *
     * @Groups({"list", "details"})
     */
    private $name;

    /**
     * @var string $slug
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=150, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=150)
     *
     * @Groups({"list", "details"})
     */
    private $slug;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Groups({"details"})
     */
    private $description;

    /**
     * @var string $name
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @Groups({"list", "details"})
     * @Accessor(getter="getLogoWebPath", setter="setLogo")
     */
    private $logo = 'default.png';

    /**
     * @var string $website
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @Groups({"list", "details"})
     */
    private $website;

    /**
     * @var int $id
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     *
     * @Assert\NotNull()
     * @Assert\Choice({1, 2, 3, 0})
     *
     * @Groups({"list", "details"})
     */
    private $type = self::TYPE_BRONZE;

    /**
     * @var int $id
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     *
     * @Assert\NotNull()
     * @Assert\Choice({0, 1, 2})
     *
     * @Groups({"list", "details"})
     */
    private $status = self::STATUS_ACTIVE;

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

    public function __construct()
    {
        $this->setCreation(new \DateTime());
    }

    /**
     * @return int
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
     * @param string $logo
     *
     * @return $this
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @return string
     */
    public function getLogoWebPath()
    {
        return 'http://' . $this->getLogoAbsoluteDir() . '/' . $this->getLogo();
    }

    /**
     * Get the logo absolute directory
     *
     * @return string
     */
    public function getLogoAbsoluteDir()
    {
        return rtrim($_SERVER['HTTP_HOST'], '/') . "/" . $this->getLogoWebDir();
    }

    /**
     * @return string
     */
    private function getLogoWebDir()
    {
        return 'files/sponsor/logo';
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param int $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $website
     *
     * @return $this
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return is_null($this->getId());
    }
}