<?php

namespace App\Entity\Tyres;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Tyres\BrandRepository")
 * @ORM\Table(name="brand", schema="tyre")
 */
class Brand
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
     * @ORM\OneToMany(targetEntity="App\Entity\Tyres\Model", mappedBy="brand")
     */
    private $models;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tyres\Tyre", mappedBy="brand")
     */
    private $tyres;

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

    public function getTyres()
    {
        return $this->tyres;
    }

    public function setTyres($tyres)
    {
        $this->tyres = $tyres;
    }

    public function getId()
    {
        return $this->id;
    }
}