<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="master_category")
 */
class MasterCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Master", mappedBy="category")
     */
    private $master;
    
    /**
     * @ORM\ManyToMany(targetEntity="Brand", mappedBy="brandCategory")
     */
    private $brand;
    
        /**
     * @ORM\ManyToMany(targetEntity="Salon", mappedBy="category")
     */
    private $salon;
    
    /**
     * @ORM\OneToMany(targetEntity="MasterCategoryService", mappedBy="category")
     */
    protected $services;
    
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $name;
    
     /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="masterCategory")
     */
    protected $product;
    
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->master = new \Doctrine\Common\Collections\ArrayCollection();
        $this->services = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity(array(
            'fields'    => array('name'),
            'message'   => 'Такая категория уже существует.',
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
     * Set name
     *
     * @param string $name
     * @return MasterCategory
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
     * Add services
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategoryService $services
     * @return MasterCategory
     */
    public function addService(\LaNet\LaNetBundle\Entity\MasterCategoryService $services)
    {
        $this->services[] = $services;
    
        return $this;
    }

    /**
     * Remove services
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategoryService $services
     */
    public function removeService(\LaNet\LaNetBundle\Entity\MasterCategoryService $services)
    {
        $this->services->removeElement($services);
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Add product
     *
     * @param \LaNet\LaNetBundle\Entity\Product $product
     * @return MasterCategory
     */
    public function addProduct(\LaNet\LaNetBundle\Entity\Product $product)
    {
        $this->product[] = $product;
    
        return $this;
    }

    /**
     * Remove product
     *
     * @param \LaNet\LaNetBundle\Entity\Product $product
     */
    public function removeProduct(\LaNet\LaNetBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Add master
     *
     * @param \LaNet\LaNetBundle\Entity\Master $master
     * @return MasterCategory
     */
    public function addMaster(\LaNet\LaNetBundle\Entity\Master $master)
    {
        $this->master[] = $master;
    
        return $this;
    }

    /**
     * Remove master
     *
     * @param \LaNet\LaNetBundle\Entity\Master $master
     */
    public function removeMaster(\LaNet\LaNetBundle\Entity\Master $master)
    {
        $this->master->removeElement($master);
    }

    /**
     * Get master
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMaster()
    {
        return $this->master;
    }

    /**
     * Add salon
     *
     * @param \LaNet\LaNetBundle\Entity\Salon $salon
     * @return MasterCategory
     */
    public function addSalon(\LaNet\LaNetBundle\Entity\Salon $salon)
    {
        $this->salon[] = $salon;
    
        return $this;
    }

    /**
     * Remove salon
     *
     * @param \LaNet\LaNetBundle\Entity\Salon $salon
     */
    public function removeSalon(\LaNet\LaNetBundle\Entity\Salon $salon)
    {
        $this->salon->removeElement($salon);
    }

    /**
     * Get salon
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSalon()
    {
        return $this->salon;
    }

    /**
     * Add brand
     *
     * @param \LaNet\LaNetBundle\Entity\Brand $brand
     * @return MasterCategory
     */
    public function addBrand(\LaNet\LaNetBundle\Entity\Brand $brand)
    {
        $this->brand[] = $brand;
    
        return $this;
    }

    /**
     * Remove brand
     *
     * @param \LaNet\LaNetBundle\Entity\Brand $brand
     */
    public function removeBrand(\LaNet\LaNetBundle\Entity\Brand $brand)
    {
        $this->brand->removeElement($brand);
    }

    /**
     * Get brand
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBrand()
    {
        return $this->brand;
    }
}