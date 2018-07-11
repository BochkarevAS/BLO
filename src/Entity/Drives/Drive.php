<?php

namespace App\Entity\Drives;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="drive", schema="drives")
 */
class Drive
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Диамитер
     *
     * @ORM\Column(type="float")
     */
    private $diameter;

    /**
     * Вылет
     *
     * @ORM\Column(type="float")
     */
    private $departure;

    /**
     * Сверловка
     *
     * @ORM\Column(type="string")
     */
    private $drilling;

    /**
     * Ширина
     *
     * @ORM\Column(type="float")
     */
    private $width;

    public function getDiameter()
    {
        return $this->diameter;
    }

    public function setDiameter($diameter)
    {
        $this->diameter = $diameter;
    }

    public function getDeparture()
    {
        return $this->departure;
    }

    public function setDeparture($departure)
    {
        $this->departure = $departure;
    }

    public function getDrilling()
    {
        return $this->drilling;
    }

    public function setDrilling($drilling)
    {
        $this->drilling = $drilling;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }
}