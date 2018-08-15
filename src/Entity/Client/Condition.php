<?php

namespace App\Entity\Client;

use Doctrine\ORM\Mapping as ORM;

/**
 * Состояние товара
 *
 * @ORM\Entity(repositoryClass="App\Repository\Client\ConditionRepository")
 * @ORM\Table(name="condition", schema="client")
 */
class Condition
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }
}