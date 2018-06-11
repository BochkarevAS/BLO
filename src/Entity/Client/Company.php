<?php

namespace App\Entity\Client;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Client\CompanyRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *  @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime('now');
    }

    public function __toString()
    {
        return $this->getName();
    }
}