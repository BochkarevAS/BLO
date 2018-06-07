<?php

namespace App\Entity\Administration;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="news_categories", schema="admin")
 */
class NewsCategories
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
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @ORM\Column(type="integer")
     */
    private $display;

    /**
     * @ORM\Column(type="integer", name="display_on_main")
     */
    private $displayOnMain;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function setDisplay($display)
    {
        $this->display = $display;
    }

    public function getDisplayOnMain()
    {
        return $this->displayOnMain;
    }

    public function setDisplayOnMain($displayOnMain)
    {
        $this->displayOnMain = $displayOnMain;
    }
}