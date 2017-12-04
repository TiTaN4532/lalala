<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;


/**
 * @ORM\Entity
 * @ORM\Table(name="service")
 */
class Service
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Master", inversedBy="services")
     */
    private $master;
    
    /**
     * @ORM\ManyToOne(targetEntity="Salon", inversedBy="services")
     */
    private $salon;
    
    /**
     * @ORM\ManyToOne(targetEntity="School", inversedBy="services")
     */
    private $school;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="integer", nullable = true)
     */
    protected $startPrice;
    
    /**
     * @ORM\Column(type="integer", nullable = true)
     */
    protected $endPrice;
    
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
     * @return SalonService
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
     * Set startPrice
     *
     * @param integer $startPrice
     * @return SalonService
     */
    public function setStartPrice($startPrice)
    {
        $this->startPrice = $startPrice;
    
        return $this;
    }

    /**
     * Get startPrice
     *
     * @return integer 
     */
    public function getStartPrice()
    {
        return $this->startPrice;
    }

    /**
     * Set endPrice
     *
     * @param integer $endPrice
     * @return SalonService
     */
    public function setEndPrice($endPrice)
    {
        $this->endPrice = $endPrice;
    
        return $this;
    }

    /**
     * Get endPrice
     *
     * @return integer 
     */
    public function getEndPrice()
    {
        return $this->endPrice;
    }

    /**
     * Set salon
     *
     * @param \LaNet\LaNetBundle\Entity\Salon $salon
     * @return SalonService
     */
    public function setSchool(\LaNet\LaNetBundle\Entity\School $school = null)
    {
        $this->school = $school;
    
        return $this;
    }

    /**
     * Get salon
     *
     * @return \LaNet\LaNetBundle\Entity\Salon 
     */
    public function getSchool()
    {
        return $this->school;
    }
    
    /**
     * Set salon
     *
     * @param \LaNet\LaNetBundle\Entity\Salon $salon
     * @return SalonService
     */
    public function setSalon(\LaNet\LaNetBundle\Entity\Salon $salon = null)
    {
        $this->salon = $salon;
    
        return $this;
    }

    /**
     * Get salon
     *
     * @return \LaNet\LaNetBundle\Entity\Salon 
     */
    public function getSalon()
    {
        return $this->salon;
    }

    /**
     * Set master
     *
     * @param \LaNet\LaNetBundle\Entity\Master $master
     * @return Service
     */
    public function setMaster(\LaNet\LaNetBundle\Entity\Master $master = null)
    {
        $this->master = $master;
    
        return $this;
    }

    /**
     * Get master
     *
     * @return \LaNet\LaNetBundle\Entity\Master 
     */
    public function getMaster()
    {
        return $this->master;
    }
}