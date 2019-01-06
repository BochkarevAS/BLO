<?php

namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment", schema="part")
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Auth\User")
     */
    private $user;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Part", inversedBy="comments")
     */
    private $product;

    /**
     * Одобрен или нет
     *
     * @ORM\Column(type="boolean")
     */
    private $approved;

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

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product)
    {
        $this->product = $product;
    }

    public function getApproved()
    {
        return $this->approved;
    }

    public function setApproved($approved): void
    {
        $this->approved = $approved;
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
        return (string) $this->getComment();
    }

    public static function createFromDto($dto): self
    {
        $comment = new self();

        $comment->setUser($dto->user);
        $comment->setComment($dto->comment);
        $comment->setProduct($dto->product);
        $comment->setApproved(true);

        return $comment;
    }
}