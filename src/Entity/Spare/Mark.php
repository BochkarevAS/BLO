<?php

namespace App\Entity\Spare;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Spare\MarkRepository")
 * @ORM\Table(name="mark", schema="spare")
 */
class Mark
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
    private $state;

    /**
     * @ORM\Column(type="integer")
     */
    private $presence;

    /**
     * @ORM\Column(type="integer")
     */
    private $locationRightLeft;

    /**
     * @ORM\Column(type="integer")
     */
    private $locationBeforeBack;

    /**
     * @ORM\Column(type="integer")
     */
    private $locationUpDown;

//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Spare\Model")
//     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
//     */
//    private $modelId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spare\Carcase")
     * @ORM\JoinColumn(name="carcase_id", referencedColumnName="id")
     */
    private $carcaseId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $cityId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $regionId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\County")
     * @ORM\JoinColumn(name="county_id", referencedColumnName="id")
     */
    private $countyId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Vendor")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     */
    private $vendorId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spare\Oem")
     * @ORM\JoinColumn(name="oem_id", referencedColumnName="id")
     */
    private $oemId;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getPresence()
    {
        return $this->presence;
    }

    public function setPresence($presence)
    {
        $this->presence = $presence;
    }

    public function getLocationRightLeft()
    {
        return $this->locationRightLeft;
    }

    public function setLocationRightLeft($locationRightLeft)
    {
        $this->locationRightLeft = $locationRightLeft;
    }

    public function getLocationBeforeBack()
    {
        return $this->locationBeforeBack;
    }

    public function setLocationBeforeBack($locationBeforeBack)
    {
        $this->locationBeforeBack = $locationBeforeBack;
    }

    public function getLocationUpDown()
    {
        return $this->locationUpDown;
    }

    public function setLocationUpDown($locationUpDown)
    {
        $this->locationUpDown = $locationUpDown;
    }

    public function getEngineId()
    {
        return $this->engineId;
    }

    public function setEngineId($engineId)
    {
        $this->engineId = $engineId;
    }

    public function getModelId()
    {
        return $this->modelId;
    }

    public function setModelId($modelId)
    {
        $this->modelId = $modelId;
    }

    public function getCarcaseId()
    {
        return $this->carcaseId;
    }

    public function setCarcaseId($carcaseId)
    {
        $this->carcaseId = $carcaseId;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function setCityId($cityId)
    {
        $this->cityId = $cityId;
    }

    public function getRegionId()
    {
        return $this->regionId;
    }

    public function setRegionId($regionId)
    {
        $this->regionId = $regionId;
    }

    public function getCountyId()
    {
        return $this->countyId;
    }

    public function setCountyId($countyId)
    {
        $this->countyId = $countyId;
    }

    public function getVendorId()
    {
        return $this->vendorId;
    }

    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    public function getOemId()
    {
        return $this->oemId;
    }

    public function setOemId($oemId)
    {
        $this->oemId = $oemId;
    }
}