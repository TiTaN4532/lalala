<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity
 * @ORM\Table(name="master_service")
 */
class MasterCategoryService
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
     * @ORM\ManyToOne(targetEntity="MasterCategory", inversedBy="services")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Master", mappedBy="services")
     */
    protected $masters;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->masters = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return MasterCategoryService
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
     * Set category
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategory $category
     * @return MasterCategoryService
     */
    public function setCategory(\LaNet\LaNetBundle\Entity\MasterCategory $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \LaNet\LaNetBundle\Entity\MasterCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add masters
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategoryServicePrice $masters
     * @return MasterCategoryService
     */
    public function addMaster(\LaNet\LaNetBundle\Entity\MasterCategoryServicePrice $masters)
    {
        $this->masters[] = $masters;
    
        return $this;
    }

    /**
     * Remove masters
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategoryServicePrice $masters
     */
    public function removeMaster(\LaNet\LaNetBundle\Entity\MasterCategoryServicePrice $masters)
    {
        $this->masters->removeElement($masters);
    }

    /**
     * Get masters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMasters()
    {
        return $this->masters;
    }
}