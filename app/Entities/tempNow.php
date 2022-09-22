<?php

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tempNow")
 */
class tempNow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity="city")
     */
    private $tempNowCityId;

    /**
     * @ORM\Column(type="float")
     */
    protected $temp;

    /**
     * @ORM\Column(type="datetimetz")
     */
    protected $timeNow;

    /**
    * @param $temp
    * @param $timeNow
    */
    public function __construct($temp, $tempNowCityId, $timeNow)
    {
        $this->tempNowCityId = $tempNowCityId;
        $this->temp = $temp;
        $this->timeNow = $timeNow;

    }

    public function getId()
    {
        return $this->id;
    }

    public function getTempNowCityId()
    {
        return $this->tempNowCityId;
    }
    public function getTemp()
    {
        return $this->temp;
    }

    public function getTimeNow()
    {
        return $this->timeNow;
    }
}