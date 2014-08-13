<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**

 */
class LocationOld
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
     * @ORM\ManyToOne(targetEntity="City", inversedBy="location")
     */
    private $city;
    
     /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="location")
     */
    private $region;
    
     /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="location")
     */
    private $country;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $district;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $station;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $street;
    
     /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $building;
 
    /**
     * @ORM\OneToOne(targetEntity="Consumer", inversedBy="location")
     */
    private $consumerInfo;
    
     /**
     * @ORM\OneToOne(targetEntity="Master", inversedBy="location")
     */
    private $masterInfo;
    
    

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
     * Set district
     *
     * @param string $district
     * @return Location
     */
    public function setDistrict($district)
    {
        $this->district = $district;
    
        return $this;
    }

    /**
     * Get district
     *
     * @return string 
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set station
     *
     * @param string $station
     * @return Location
     */
    public function setStation($station)
    {
        $this->station = $station;
    
        return $this;
    }

    /**
     * Get station
     *
     * @return string 
     */
    public function getStation()
    {
        return $this->station;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Location
     */
    public function setStreet($street)
    {
        $this->street = $street;
    
        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set building
     *
     * @param string $building
     * @return Location
     */
    public function setBuilding($building)
    {
        $this->building = $building;
    
        return $this;
    }

    /**
     * Get building
     *
     * @return string 
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set city
     *
     * @param \LaNet\LaNetBundle\Entity\City $city
     * @return Location
     */
    public function setCity(\LaNet\LaNetBundle\Entity\City $city = null)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return \LaNet\LaNetBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set region
     *
     * @param \LaNet\LaNetBundle\Entity\Region $region
     * @return Location
     */
    public function setRegion(\LaNet\LaNetBundle\Entity\Region $region = null)
    {
        $this->region = $region;
    
        return $this;
    }

    /**
     * Get region
     *
     * @return \LaNet\LaNetBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set country
     *
     * @param \LaNet\LaNetBundle\Entity\Country $country
     * @return Location
     */
    public function setCountry(\LaNet\LaNetBundle\Entity\Country $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return \LaNet\LaNetBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
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
}