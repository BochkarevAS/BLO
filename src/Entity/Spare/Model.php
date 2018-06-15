<?php

namespace App\Entity\Spare;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Spare\ModelRepository")
 * @ORM\Table(name="model", schema="spare")
 */
class Model
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Spare\Engine", inversedBy="models")
     * @ORM\JoinTable(name="model_engine", schema="spare")
     */
    private $engines;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Spare\SparePart", inversedBy="models")
     * @ORM\JoinTable(name="model_spare", schema="spare")
     */
    private $spareParts;

    public function addEngine(Engine $engine)
    {
        $engine->addModel($this);
        $this->engines[] = $engine;
    }

    public function addSparePart(SparePart $sparePart)
    {
        $sparePart->addModel($this);
        $this->spareParts[] = $sparePart;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEngines()
    {
        return $this->engines;
    }

    public function setEngines($engine)
    {
        $this->engines = $engine;
    }

    public function getSpareParts()
    {
        return $this->spareParts;
    }

    public function setSpareParts($spareParts)
    {
        $this->spareParts = $spareParts;
    }
}