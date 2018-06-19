<?php

namespace App\Entity\Spare;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Spare\MarkRepository")
 * @ORM\Table(name="mark", schema="spare")
 */
class Mark
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
     * @ORM\OneToMany(targetEntity="App\Entity\Spare\Model", mappedBy="mark")
     */
    private $models;

    public function __construct()
    {
        $this->models = new ArrayCollection();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getModels()
    {
        return $this->models;
    }

    public function setModels($models)
    {
        $this->models = $models;
    }
}