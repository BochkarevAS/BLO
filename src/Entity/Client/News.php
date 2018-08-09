<?php

namespace App\Entity\Client;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="news", schema="client")
 */
class News
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * Фотографии
     *
     * @ORM\Column(type="json")
     */
    private $picture;

    /**
     * @Gedmo\Slug(fields={"name"}, unique=false)
     * @ORM\Column(type="string")
     */
    private $slag;

    /**
     * @ORM\Column(type="integer")
     */
    private $display;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $massage;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private $updatedAt;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getMassage()
    {
        return $this->massage;
    }

    public function setMassage($massage)
    {
        $this->massage = $massage;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture): void
    {
        $this->picture = $picture;
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function setDisplay($display)
    {
        $this->display = $display;
    }

    public function getSlag()
    {
        return $this->slag;
    }

    public function setSlag($slag): void
    {
        $this->slag = $slag;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }
}