<?php

namespace App\Entity\Tyres\Profile;

use Doctrine\ORM\Mapping as ORM;

/**
 * Высота профиля
 *
 * @ORM\Entity
 * @ORM\Table(name="profile_height", schema="tyres")
 */
class ProfileHeight
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}