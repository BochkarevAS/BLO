<?php

namespace App\Entity\Region;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="region", schema="region")
 */
class Region
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
     * @ORM\OneToMany(targetEntity="App\Entity\Region\City", mappedBy="region")
     */
    private $citys;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCitys()
    {
        return $this->citys;
    }

    public function setCitys($citys): void
    {
        $this->citys = $citys;
    }
}