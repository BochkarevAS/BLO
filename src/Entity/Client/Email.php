<?php

namespace App\Entity\Client;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="email", schema="client")
 * @UniqueEntity(
 *     fields={"address"},
 *     message="Такой адрес уже существует !!!",
 *     errorPath="address"
 * )
 */
class Email
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Company", inversedBy="emails")
     */
    private $company;

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address): void
    {
        $this->address = $address;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company): void
    {
        $this->company = $company;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->getAddress();
    }
}