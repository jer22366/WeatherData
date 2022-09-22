<?php

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="twoDayWeather")
 */
class twoDayWeather
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $twoDayCityId;

    /**
     * @ORM\Column(type="integer")
     */
    protected $descriptionT;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @ORM\Column(type="datetimetz")
     */
    protected $startTime;

    /**
     * @ORM\Column(type="datetimetz")
     */
    protected $endTime;

    /**
    * @param $twoDayCityId
    * @param $descriptionT
    * @param $description
    * @param $startTime
    * @param $endTime
    */
    public function __construct($descriptionT, $startTime, $endTime, $twoDayCityId, $description)
    {
        
        $this->twoDayCityId = $twoDayCityId;
        $this->descriptionT  = $descriptionT;
        $this->endTime  = $endTime;
        $this->description = $description;
        $this->startTime = $startTime;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTwoDayCityId()
    {
        return $this->twoDayCityId;
    }
    
    public function getDescriptionT()
    {
        return $this->descriptionT;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }
}