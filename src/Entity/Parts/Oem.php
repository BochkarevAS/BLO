<?php

namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oem", schema="part")
 */
class Oem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNameSuggest()
    {
        return [
            'input' => explode(' ', $this->getName())
        ];
    }

    public function getOutput()
    {
        return $this->getName();
    }
}