<?php

namespace App\Entity\Client;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Client\CompanyRepository")
 * @ORM\Table(name="company", schema="client")
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Название компании
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * Краткая информация о компании
     *
     * @ORM\Column(type="string")
     */
    private $info;

    /**
     * Головной офис
     *
     * @ORM\Column(type="string")
     */
    private $office;

    /**
     * Город
     *
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * Сайт
     *
     * @ORM\Column(type="string")
     */
    private $syte;

    /**
     * Активные разделы с прайсами (запчасти)
     *
     * @ORM\Column(type="boolean", name="sections_parts")
     */
    private $sectionsParts;

    /**
     * Активные разделы с прайсами (шины)
     *
     * @ORM\Column(type="boolean", name="sections_tyres")
     */
    private $sectionsTyres;

    /**
     * Активные разделы с прайсами (диски)
     *
     * @ORM\Column(type="boolean", name="sections_drives")
     */
    private $sectionsDrives;

    /**
     * ID от App\Entity\Auth\User;
     *
     * @ORM\Column(type="integer", name="user_id")
     */
    private $userId;

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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function setInfo($info): void
    {
        $this->info = $info;
    }

    public function getOffice()
    {
        return $this->office;
    }

    public function setOffice($office): void
    {
        $this->office = $office;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city): void
    {
        $this->city = $city;
    }

    public function getSyte()
    {
        return $this->syte;
    }

    public function setSyte($syte): void
    {
        $this->syte = $syte;
    }

    public function getSectionsParts()
    {
        return $this->sectionsParts;
    }

    public function setSectionsParts($sectionsParts): void
    {
        $this->sectionsParts = $sectionsParts;
    }

    public function getSectionsTyres()
    {
        return $this->sectionsTyres;
    }

    public function setSectionsTyres($sectionsTyres): void
    {
        $this->sectionsTyres = $sectionsTyres;
    }

    public function getSectionsDrives()
    {
        return $this->sectionsDrives;
    }

    public function setSectionsDrives($sectionsDrives): void
    {
        $this->sectionsDrives = $sectionsDrives;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function getId()
    {
        return $this->id;
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