<?php

namespace App\Entity\Drives;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="brand", schema="drives")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Drives\Drive", mappedBy="brands")
     */
    private $drive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Drives\Model", mappedBy="brands")
     */
    private $model;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getDrive()
    {
        return $this->drive;
    }

    public function setDrive($drive): void
    {
        $this->drive = $drive;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model): void
    {
        $this->model = $model;
    }
}