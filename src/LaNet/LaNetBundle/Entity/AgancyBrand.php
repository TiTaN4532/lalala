<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="agancy_brand")
 */
class AgancyBrand
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


   /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    protected $oficial;
    
   /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $type;
    
   /**
     * @ORM\ManyToOne(targetEntity="Agancy", inversedBy="agancyBrand")
     */
    protected $agancy;

    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="agancyBrand")
     */
    protected $brand;

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
     * @return AgancyBrand
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
     * Set oficial
     *
     * @param boolean $oficial
     * @return AgancyBrand
     */
    public function setOficial($oficial)
    {
        $this->oficial = $oficial;
    
        return $this;
    }

    /**
     * Get oficial
     *
     * @return boolean 
     */
    public function getOficial()
    {
        return $this->oficial;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return AgancyBrand
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set agancy
     *
     * @param \LaNet\LaNetBundle\Entity\Agancy $agancy
     * @return AgancyBrand
     */
    public function setAgancy(\LaNet\LaNetBundle\Entity\Agancy $agancy = null)
    {
        $this->agancy = $agancy;
    
        return $this;
    }

    /**
     * Get agancy
     *
     * @return \LaNet\LaNetBundle\Entity\Agancy 
     */
    public function getAgancy()
    {
        return $this->agancy;
    }

    /**
     * Set brand
     *
     * @param \LaNet\LaNetBundle\Entity\Brand  $brand
     * @return AgancyBrand
     */
    public function setBrand(\Acme\UserBundle\Entity\User $brand = null)
    {
        $this->brand = $brand;
    
        return $this;
    }

    /**
     * Get brand
     *
     * @return \LaNet\LaNetBundle\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }
}