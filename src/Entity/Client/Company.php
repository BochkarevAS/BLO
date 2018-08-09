<?php

namespace App\Entity\Client;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="text")
     */
    private $preview;

    /**
     * Банковские реквизиты
     *
     * @ORM\Column(type="text")
     */
    private $bank;

    /**
     * Город
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Region\City")
     */
    private $city;

    /**
     * Сайт
     *
     * @ORM\Column(type="string")
     */
    private $syte;

    /**
     * Активные разделы в личном кобинете
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Client\Section", inversedBy="company")
     * @ORM\JoinTable(name="company_sections", schema="client")
     */
    private $sections;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Auth\User")
     */
    private $user;

    /**
     * Логотип компании
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $logotype;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client\Phone", mappedBy="company", orphanRemoval=true,  cascade={"persist"})
     * @Assert\Valid()
     */
    private $phones;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client\Email", mappedBy="company", orphanRemoval=true,  cascade={"persist"})
     * @Assert\Valid()
     */
    private $emails;

    /**
     * Адрес компании
     *
     * @ORM\Column(type="text")
     */
    private $address;

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

    public function __construct()
    {
        $this->phones   = new ArrayCollection();
        $this->emails   = new ArrayCollection();
        $this->sections = new ArrayCollection();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getPreview()
    {
        return $this->preview;
    }

    public function setPreview($preview)
    {
        $this->preview = $preview;
    }

    public function getBank()
    {
        return $this->bank;
    }

    public function setBank($bank)
    {
        $this->bank = $bank;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getSyte()
    {
        return $this->syte;
    }

    public function setSyte($syte)
    {
        $this->syte = $syte;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
    * @return ArrayCollection|Phone[]
    */
    public function getPhones()
    {
        return $this->phones;
    }

    public function addPhone(Phone $phones)
    {
        if ($this->phones->contains($phones)) {
            return;
        }

        $this->phones[] = $phones;
        $phones->setCompany($this);
    }

    public function removePhone(Phone $phones)
    {
        if (!$this->phones->contains($phones)) {
            return;
        }

        $this->phones->removeElement($phones);
        $phones->setCompany(null);
    }

    /**
     * @return ArrayCollection|Email[]
     */
    public function getEmails()
    {
        return $this->emails;
    }

    public function addEmail(Email $emails)
    {
        if ($this->emails->contains($emails)) {
            return;
        }

        $this->emails[] = $emails;
        $emails->setCompany($this);
    }

    public function removeEmail(Email $emails)
    {
        if (!$this->emails->contains($emails)) {
            return;
        }

        $this->emails->removeElement($emails);
        $emails->setCompany(null);
    }

    /**
     * @return ArrayCollection|Section[]
     */
    public function getSections()
    {
        return $this->sections;
    }

    public function addSection(Section $section)
    {
        if ($this->sections->contains($section)) {
            return;
        }

        $this->sections[] = $section;
        $section->setCompany($this);
    }

    public function removeSection(Section $section)
    {
        if (!$this->sections->contains($section)) {
            return;
        }

        $this->sections->removeElement($section);
        $section->setCompany(null);
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address): void
    {
        $this->address = $address;
    }

    public function getLogotype()
    {
        return $this->logotype;
    }

    public function setLogotype($logotype): void
    {
        $this->logotype = $logotype;
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

    public function __toString()
    {
        return (string) $this->getName();
    }
}