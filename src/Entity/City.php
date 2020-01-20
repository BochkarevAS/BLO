<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="citys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Country", mappedBy="city")
     */
    private $countrys;

    public function __construct()
    {
        $this->countrys = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Collection|Country[]
     */
    public function getCountrys(): Collection
    {
        return $this->countrys;
    }

    public function addUser(Country $country): self
    {
        if (!$this->countrys->contains($country)) {
            $this->countrys[] = $country;
            $country->setCity($this);
        }

        return $this;
    }

    public function removeUser(Country $country): self
    {
        if ($this->countrys->contains($country)) {
            $this->countrys->removeElement($country);

            if ($country->getCity() === $this) {
                $country->setCity(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->name;
    }
}