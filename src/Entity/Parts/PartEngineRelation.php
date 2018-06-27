<?php

namespace App\Entity\Parts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="part_engine_city_relation", schema="parts")
 */
class PartEngineRelation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Engine", inversedBy="relation")
     */
    private $engines;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Part", inversedBy="relation")
     */
    private $parts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\City", inversedBy="relation")
     */
    private $citys;

    public function __construct()
    {
        $this->engines = new ArrayCollection();
        $this->citys   = new ArrayCollection();
        $this->parts   = new ArrayCollection();
    }

    public function getCitys()
    {
        return $this->citys;
    }

    public function setCitys($citys)
    {
        $this->citys = $citys;
    }

    public function getEngines()
    {
        return $this->engines;
    }

    public function setEngines($engines)
    {
        $this->engines = $engines;
    }

    public function getParts()
    {
        return $this->parts;
    }

    public function setParts($parts)
    {
        $this->parts = $parts;
    }
}