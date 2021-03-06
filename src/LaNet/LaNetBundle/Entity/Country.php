<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name = "country")
 * @ORM\Entity
 */
class Country
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
     * @ORM\OneToMany(targetEntity="Location", mappedBy="country")
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
     * @return Country
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
     * Constructor
     */
    public function __construct()
    {
        $this->region = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add region
     *
     * @param \LaNet\LaNetBundle\Entity\Region $region
     * @return Country
     */
    public function addRegion(\LaNet\LaNetBundle\Entity\Region $region)
    {
        $this->region[] = $region;
    
        return $this;
    }

    /**
     * Remove region
     *
     * @param \LaNet\LaNetBundle\Entity\Region $region
     */
    public function removeRegion(\LaNet\LaNetBundle\Entity\Region $region)
    {
        $this->region->removeElement($region);
    }

    /**
     * Get region
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Add location
     *
     * @param \LaNet\LaNetBundle\Entity\Location $location
     * @return Country
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