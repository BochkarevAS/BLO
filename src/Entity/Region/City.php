<?php

namespace App\Entity\Region;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Region\CityRepository")
 * @ORM\Table(name="city", schema="region")
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App\Entity\Parts\PartEngineRelation", mappedBy="citys")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\Region", inversedBy="citys")
     */
    private $region;

    /**
     * @ORM\Column(type="string")
     */
    private $coordinate;

    public function __construct()
    {
        $this->region = new ArrayCollection();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setRegion($region): void
    {
        $this->region[] = $region;
    }

    public function getCoordinate()
    {
        return $this->coordinate;
    }

    public function setCoordinate($coordinate): void
    {
        $this->coordinate = $coordinate;
    }

    public function getId()
    {
        return $this->id;
    }
}