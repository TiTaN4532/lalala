<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Region
 *
 * @ORM\Table(name = "region")
 * @ORM\Entity
 */
class Region
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
     *@ORM\Column(type="string", length=100)
     */
    private $country_id;
    

     /**
     * @ORM\OneToMany(targetEntity="Location", mappedBy="region")
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
     * @return Region
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
     * @return Region
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
     * Constructor
     */
    public function __construct()
    {
        $this->city = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add city
     *
     * @param \LaNet\LaNetBundle\Entity\City $city
     * @return Region
     */
    public function addCity(\LaNet\LaNetBundle\Entity\City $city)
    {
        $this->city[] = $city;
    
        return $this;
    }

    /**
     * Remove city
     *
     * @param \LaNet\LaNetBundle\Entity\City $city
     */
    public function removeCity(\LaNet\LaNetBundle\Entity\City $city)
    {
        $this->city->removeElement($city);
    }

    /**
     * Get city
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Add location
     *
     * @param \LaNet\LaNetBundle\Entity\Location $location
     * @return Region
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