<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name = "city")
 * @ORM\Entity
 */
class City
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
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
     /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="city")
     */
    private $region;
        
    /**
     * @ORM\OneToMany(targetEntity="Location", mappedBy="city")
     */
    private $location;
    

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
     * Set name
     *
     * @param string $name
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set country
     *
     * @param \LaNet\LaNetBundle\Entity\Country $country
     * @return City
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
     * Set region
     *
     * @param \LaNet\LaNetBundle\Entity\Region $region
     * @return City
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
     * Set consumerInfo
     *
     * @param \LaNet\LaNetBundle\Entity\Consumer $consumerInfo
     * @return City
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
     * Constructor
     */
    public function __construct()
    {
        $this->location = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add location
     *
     * @param \LaNet\LaNetBundle\Entity\Location $location
     * @return City
     */
    public function addLocation(\LaNet\LaNetBundle\Entity\Location $location)
    {
        $this->location[] = $location;
    
        return $this;
    }

    /**
     * Remove location
     *
     * @param \LaNet\LaNetBundle\Entity\Location $location
     */
    public function removeLocation(\LaNet\LaNetBundle\Entity\Location $location)
    {
        $this->location->removeElement($location);
    }

    /**
     * Get location
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocation()
    {
        return $this->location;
    }
}