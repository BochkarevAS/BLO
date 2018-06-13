<?php

namespace App\Entity\Spare;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="spare_engine", schema="spare")
 */
class SpareEngine
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
     * @ORM\Column(type="string")
     */
    private $mark;

    /**
     * @ORM\Column(type="string")
     */
    private $carcase;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\City", inversedBy="engine")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\Region", inversedBy="engine")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\County", inversedBy="engine")
     * @ORM\JoinColumn(nullable=false)
     */
    private $county;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Vendor", inversedBy="engine")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Vendor", inversedBy="engine")
     * @ORM\JoinColumn(nullable=false)
     */
    private $oem;

}