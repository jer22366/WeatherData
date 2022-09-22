<?php

use Doctrine\ORM\Mapping AS ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="rain")
 */
class rain
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rainCityId;

    /**
     * @ORM\Column(type="float")
     */
    protected $oneHourRain;

    /**
     * @ORM\Column(type="float")
     */
    protected $oneDayRain;

    /**
     * @ORM\Column(type="datetimetz")
     */
    protected $rainDate;

    /**
    * @param $cityId
    * @param $oneHourRain
    * @param $oneDayRain
    * @param $rainDate
    */
    public function __construct($oneHourRain, $oneDayRain, $rainDate, $rainCityId)
    {
        
        $this->oneHourRain  = $oneHourRain;
        $this->oneDayRain  = $oneDayRain;
        $this->rainDate  = $rainDate;
        $this->rainCityId = $rainCityId;

    }

    public function getId()
    {
        return $this->id;
    }

    public function getOneHourRain()
    {
        return $this->oneHourRain;
    }

    public function getOneDayRain()
    {
        return $this->oneDayRain;
    }

    public function getRainDate()
    {
        return $this->rainDate;
    }

    public function getCityId()
    {
        return $this->rainCityId;
    }
    
}