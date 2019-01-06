<?php

namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="catalog", schema="part")
 */
class Catalog
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

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNameSuggest()
    {
        $name = preg_replace('/^ +| +$|( ) +/m', '$1', $this->getName());

        return [
            'input' => explode(' ', $name)
        ];
    }

    public function getOutput()
    {
        return trim($this->getName());
    }
}