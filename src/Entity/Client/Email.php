<?php

namespace App\Entity\Client;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="email", schema="client")
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
}