<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;


/**
 * @ORM\Entity
 * @ORM\Table(name="new_master_service")
 */
class MasterService
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Master", inversedBy="services")
     * @ORM\JoinColumn(name="master_id", referencedColumnName="id")
     */
    private $master;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $startPrice;
    
    /**
     * @ORM\Column(type="integer")
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
     * Set startPrice
     *
     * @param integer $startPrice
     * @return MasterService
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
     * @return MasterService
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
     * Set master
     *
     * @param \LaNet\LaNetBundle\Entity\Master $master
     * @return MasterService
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

    /**
     * Set name
     *
     * @param string $name
     * @return MasterService
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
}