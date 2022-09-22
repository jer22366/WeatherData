<?php

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oneWeekWeather")
 */
class oneWeekWeather
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
    private $oneWeekCityId;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @ORM\Column(type="integer")
     */
    protected $MaxT;
    /**
     * @ORM\Column(type="integer")
     */
    protected $MinT;
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
    * @param $description
    * @param $startTime
    * @param $endTime
    * @param $MaxT
    * @param $MinT
    */
    public function __construct($startTime, $endTime, $oneWeekCityId, $description, $MaxT, $MinT)
    {
        
        $this->oneWeekCityId = $oneWeekCityId;
        $this->description = $description;
        $this->startTime = $startTime;
        $this->endTime  = $endTime;
        $this->MaxT = $MaxT;
        $this->MinT = $MinT;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOneWeekCityId()
    {
        return $this->oneWeekCityId;
    }

    public function getDescription()
    {
        return $this->description;
    }
    
    public function getStartTime()
    {
        return $this->startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function getMaxT()
    {
        return $this->MaxT;
    }

    public function getMinT()
    {
        return $this->MinT;
    }
}