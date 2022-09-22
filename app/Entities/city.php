<?php

use Doctrine\ORM\Mapping AS ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="city")
 */
class city
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $cityId;

    /**
     * @ORM\Column(type="string")
     */
    protected $city;

    /**
     * @ORM\Column(type="string")
     */
    protected $cityImg;

    /**
    * @param $city
    * @param $cityimg
    */
    public function __construct($city, $cityimg)
    {
        
        $this->city  = $city;
        $this->cityimg  = $cityimg;

    }

    public function getCityId()
    {
        return $this->cityid;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getCityimg()
    {
        return $this->cityimg;
    }
}