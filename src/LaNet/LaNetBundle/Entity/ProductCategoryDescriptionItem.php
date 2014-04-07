<?php
namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="product_category_description_item")
 */
class ProductCategoryDescriptionItem
{
  /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
     /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="descriptionItem",cascade={"persist"})
     */
    private $category;
    
    /**
     * @ORM\OneToMany(targetEntity="ProductCategoryDescriptionName", mappedBy="descriptionItem")
     */
    protected $descriptionName;
    
  

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
     * @return ProductCategory
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
        $this->descriptionName = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set category
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategory $category
     * @return ProductCategoryDescriptionItem
     */
    public function setCategory(\LaNet\LaNetBundle\Entity\ProductCategory $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \LaNet\LaNetBundle\Entity\ProductCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add descriptionName
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategoryDescriptionName $descriptionName
     * @return ProductCategoryDescriptionItem
     */
    public function addDescriptionName(\LaNet\LaNetBundle\Entity\ProductCategoryDescriptionName $descriptionName)
    {
        $this->descriptionName[] = $descriptionName;
    
        return $this;
    }

    /**
     * Remove descriptionName
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategoryDescriptionName $descriptionName
     */
    public function removeDescriptionName(\LaNet\LaNetBundle\Entity\ProductCategoryDescriptionName $descriptionName)
    {
        $this->descriptionName->removeElement($descriptionName);
    }

    /**
     * Get descriptionName
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDescriptionName()
    {
        return $this->descriptionName;
    }
}