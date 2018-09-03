<?php

namespace App\Entity\Drives;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Tyre\CommentRepository")
 * @ORM\Table(name="comment", schema="drive")
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Drives\Drive", inversedBy="comments")
     */
    private $drive;

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

    public function getDrive()
    {
        return $this->drive;
    }

    public function setDrive($drive): void
    {
        $this->drive = $drive;
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
}