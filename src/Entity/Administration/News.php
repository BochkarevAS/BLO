<?php

namespace App\Entity\Administration;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"name"}, unique=false)
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Client\Company", inversedBy="news")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\Column(type="integer")
     */
    private $display;

    /**
     * @ORM\Column(type="integer", name="display_on_main")
     */
    private $displayOnMain;

    /**
     * @ORM\Column(type="integer")
     */
    private $uid;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $massage;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $keywords;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getMassage()
    {
        return $this->massage;
    }

    public function setMassage($massage)
    {
        $this->massage = $massage;
    }

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

    /**
     *  @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getTypeNews()
    {
        return $this->typeNews;
    }

    public function setTypeNews($typeNews)
    {
        $this->typeNews = $typeNews;
    }

    public function getIdCompany()
    {
        return $this->company;
    }

    public function setIdCompany($company)
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