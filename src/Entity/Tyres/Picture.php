<?php

namespace App\Entity\Tyres;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Сущность для хранения фотографий с шинами
 *
 * @ORM\Entity
 * @ORM\Table(name="picture", schema="tyres")
 */
class Picture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Путь по которому лежит фотография
     *
     * @ORM\Column(type="json")
     */
    private $path;

    /**
     * Хранится ID модуля например 1 это модуль шин.
     *
     * @ORM\Column(type="integer")
     */
    private $idModule;

    /**
     * ID шин
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Tyres\Tyre")
     * @ORM\JoinColumn(name="tyres_id", referencedColumnName="id")
     */
    private $tyres;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private $updatedAt;

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getTyres()
    {
        return $this->tyres;
    }

    public function setTyres($tyres)
    {
        $this->tyres = $tyres;
    }

    public function getIdModule()
    {
        return $this->idModule;
    }

    public function setIdModule($idModule)
    {
        $this->idModule = $idModule;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}