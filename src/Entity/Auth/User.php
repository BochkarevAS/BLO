<?php

namespace App\Entity\Auth;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="user", schema="security")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client\Phone", mappedBy="user")
     */
    protected $phones;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client\Company", mappedBy="company")
     */
    protected $companys;

    public function setEmail($email)
    {
        $this->setUsername($email);

        return parent::setEmail($email);
    }

    public function getId()
    {
        return $this->id;
    }
}