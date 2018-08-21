<?php

namespace App\Entity\Region;

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
        $this->region = $region;
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

    public function __toString()
    {
        return (string) $this->getName();
    }
}