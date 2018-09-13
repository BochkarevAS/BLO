<?php

namespace App\Entity\Client;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Избранное
 *
 * @ORM\Entity(repositoryClass="App\Repository\Client\FavoriteRepository")
 * @ORM\Table(name="favorite", schema="client")
 */
class Favorite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * ID пользователя
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Auth\User", inversedBy="favorites")
     */
    private $user;

    /**
     * ID продукта. Запчасть, шина, диск ...
     *
     * @ORM\Column(type="integer")
     */
    private $product;

    /**
     * Тип товара запчасить = 1, шина = 2, диск = 3 ...
     *
     * @ORM\Column(type="integer")
     */
    private $type;

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

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product): void
    {
        $this->product = $product;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
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