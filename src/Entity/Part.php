<?php

declare(strict_types=1);

namespace App\Entity\Parts;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartRepository")
 * @ORM\Table(name="part", schema="part")
 */
class Part
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Название запчасти
     *
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * Цена. Не может быть null.
     *
     * @ORM\Column(type="decimal")
     */
    private $price = 0.0;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $images;

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

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = 1000000 < intval($price) ? 0.0 : intval($price);
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setImages(?array $images): void
    {
        $this->images = empty($images) ? null : $images;
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
}