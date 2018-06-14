<?php

namespace App\Entity\Spare;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="model_engine_reference", schema="spare")
 */
class ModelEngineReference
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spare\Engine", inversedBy="model")
     */
    private $engine;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spare\Model", inversedBy="engine")
     */
    private $model;

}