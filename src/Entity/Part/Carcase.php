<?php

namespace App\Entity\Part;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="carcase", schema="part")
 */
class Carcase
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Part\Model", mappedBy="carcases")
     */
    private $models;

    public function __construct()
    {
        $this->models = new ArrayCollection();
    }

    public function addModel(Model $model)
    {
        if ($this->models->contains($model)) {
            return;
        }

        $this->models->add($model);
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