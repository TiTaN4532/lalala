<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;


/**
 * @ORM\Entity
 * @ORM\Table(name="master_service_price")
 */
class MasterCategoryServicePrice
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
     * @ORM\ManyToOne(targetEntity="MasterCategoryService", inversedBy="masters", cascade={"persist"})
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     */
    private $services;
    
    /**
     * @ORM\ManyToOne(targetEntity="Master", inversedBy="services")
     * @ORM\JoinColumn(name="master_id", referencedColumnName="id")
     */
    private $master;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $price;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

        $metadata->addConstraint(new UniqueEntity(array(
            'fields'    => array('services', 'master'),
            'message'   => 'This speciality is already exist.',
        )));
    }
    
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
     * Set price
     *
     * @param integer $price
     * @return MasterCategoryServicePrice
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set services
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategoryService $services
     * @return MasterCategoryServicePrice
     */
    public function setServices(\LaNet\LaNetBundle\Entity\MasterCategoryService $services = null)
    {
        $this->services = $services;
    
        return $this;
    }

    /**
     * Get services
     *
     * @return \LaNet\LaNetBundle\Entity\MasterCategoryService 
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set master
     *
     * @param \LaNet\LaNetBundle\Entity\Master $master
     * @return MasterCategoryServicePrice
     */
    public function setMaster(\LaNet\LaNetBundle\Entity\Master $master = null)
    {
        $this->master = $master;
    
        return $this;
    }

    /**
     * Get masters
     *
     * @return \LaNet\LaNetBundle\Entity\Master 
     */
    public function getMaster()
    {
        return $this->master;
    }
}