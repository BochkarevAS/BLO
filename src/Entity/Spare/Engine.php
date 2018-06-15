<?php

namespace App\Entity\Spare;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="engine", schema="spare")
 */
class Engine
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Spare\Model", mappedBy="engines")
     */
    private $models;

    public function addModel(Model $model)
    {
        $this->models[] = $model;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setModels($model)
    {
        $this->models = $model;
    }

    public function getModels()
    {
        return $this->models;
    }
}