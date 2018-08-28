<?php

namespace App\Entity\Client;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
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
     * Текст комментария
     *
     * @ORM\Column("text")
     */
    private $message;

    /**
     * ID пользователя
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Auth\User")
     */
    private $user;

    /**
     * ID модуля 1 - запчасть, 2 - шины ...
     *
     * @ORM\Column("integer")
     */
    private $module;


    private $owner;

    public function getModule()
    {
        return $this->module;
    }

    public function setModule($module): void
    {
        $this->module = $module;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message): void
    {
        $this->message = $message;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getId()
    {
        return $this->id;
    }
}