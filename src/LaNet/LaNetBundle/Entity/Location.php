<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name = "location")
 * @ORM\Entity
 */
class Location
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

  
     /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $country;
    
     /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $administrative_area;
    
     /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $locality;
    
     /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $sublocality;
    
     /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $route;
    
     /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $streetNumber;
    
     /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lang;
    
     /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lat;
    
 
    /**
     * @ORM\OneToOne(targetEntity="Consumer", inversedBy="location")
     */
    private $consumerInfo;
    
     /**
     * @ORM\OneToOne(targetEntity="Master", inversedBy="location")
     */
    private $masterInfo;
    
     /**
     * @ORM\OneToOne(targetEntity="Salon", inversedBy="location")
     */
    private $salonInfo;
    
     /**
     * @ORM\OneToOne(targetEntity="Agancy", inversedBy="location")
     */
    private $agancyInfo;
    
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    
    

    /**
     * Set consumerInfo
     *
     * @param \LaNet\LaNetBundle\Entity\Consumer $consumerInfo
     * @return Location
     */
    public function setConsumerInfo(\LaNet\LaNetBundle\Entity\Consumer $consumerInfo = null)
    {
        $this->consumerInfo = $consumerInfo;
    
        return $this;
    }

    /**
     * Get consumerInfo
     *
     * @return \LaNet\LaNetBundle\Entity\Consumer 
     */
    public function getConsumerInfo()
    {
        return $this->consumerInfo;
    }

    /**
     * Set masterInfo
     *
     * @param \LaNet\LaNetBundle\Entity\Master $masterInfo
     * @return Location
     */
    public function setMasterInfo(\LaNet\LaNetBundle\Entity\Master $masterInfo = null)
    {
        $this->masterInfo = $masterInfo;
    
        return $this;
    }

    /**
     * Get masterInfo
     *
     * @return \LaNet\LaNetBundle\Entity\Master 
     */
    public function getMasterInfo()
    {
        return $this->masterInfo;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Location
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set administrative_area
     *
     * @param string $administrativeArea
     * @return Location
     */
    public function setAdministrativeArea($administrativeArea)
    {
        $this->administrative_area = $administrativeArea;
    
        return $this;
    }

    /**
     * Get administrative_area
     *
     * @return string 
     */
    public function getAdministrativeArea()
    {
        return $this->administrative_area;
    }

    /**
     * Set locality
     *
     * @param string $locality
     * @return Location
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;
    
        return $this;
    }

    /**
     * Get locality
     *
     * @return string 
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set sublocality
     *
     * @param string $sublocality
     * @return Location
     */
    public function setSublocality($sublocality)
    {
        $this->sublocality = $sublocality;
    
        return $this;
    }

    /**
     * Get sublocality
     *
     * @return string 
     */
    public function getSublocality()
    {
        return $this->sublocality;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return Location
     */
    public function setRoute($route)
    {
        $this->route = $route;
    
        return $this;
    }

    /**
     * Get route
     *
     * @return string 
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set streetNumber
     *
     * @param string $streetNumber
     * @return Location
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
    
        return $this;
    }

    /**
     * Get streetNumber
     *
     * @return string 
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * Set lang
     *
     * @param string $lang
     * @return Location
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    
        return $this;
    }

    /**
     * Get lang
     *
     * @return string 
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return Location
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    
        return $this;
    }

    /**
     * Get lat
     *
     * @return string 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set salonInfo
     *
     * @param \LaNet\LaNetBundle\Entity\Salon $salonInfo
     * @return Location
     */
    public function setSalonInfo(\LaNet\LaNetBundle\Entity\Salon $salonInfo = null)
    {
        $this->salonInfo = $salonInfo;
    
        return $this;
    }

    /**
     * Get salonInfo
     *
     * @return \LaNet\LaNetBundle\Entity\Salon 
     */
    public function getSalonInfo()
    {
        return $this->salonInfo;
    }

    /**
     * Set agancyInfo
     *
     * @param \LaNet\LaNetBundle\Entity\Agancy $agancyInfo
     * @return Location
     */
    public function setAgancyInfo(\LaNet\LaNetBundle\Entity\Agancy $agancyInfo = null)
    {
        $this->agancyInfo = $agancyInfo;
    
        return $this;
    }

    /**
     * Get agancyInfo
     *
     * @return \LaNet\LaNetBundle\Entity\Agancy 
     */
    public function getAgancyInfo()
    {
        return $this->agancyInfo;
    }
}