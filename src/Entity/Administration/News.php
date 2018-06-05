<?php

namespace App\Entity\Administration;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="news", schema="admin")
 */
class News
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
    private $img;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"}, unique=false)
     * @ORM\Column(type="string")
     */
    private $url;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", name="type_news")
     */
    private $typeNews;

    /**
     * @ORM\Column(type="string")
     */
    private $company;

    /**
     * @ORM\Column(type="string")
     */
    private $display;

    /**
     * @ORM\Column(type="string", name="display_on_main")
     */
    private $displayOnMain;

    /**
     * @ORM\Column(type="string")
     */
    private $uid;

    public function getId()
    {
        return $this->id;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img = $img;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getTypeNews()
    {
        return $this->typeNews;
    }

    public function setTypeNews($typeNews)
    {
        $this->typeNews = $typeNews;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;
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

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }
}