<?php
namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="product_category_description_name")
 */
class ProductCategoryDescriptionName
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
     * @ORM\ManyToOne(targetEntity="ProductCategoryDescriptionItem", inversedBy="descriptionName")
     */
    private $descriptionItem;

    
  

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
     * Set descriptionItem
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategoryDescriptionItem $descriptionItem
     * @return ProductCategoryDescriptionName
     */
    public function setDescriptionItem(\LaNet\LaNetBundle\Entity\ProductCategoryDescriptionItem $descriptionItem = null)
    {
        $this->descriptionItem = $descriptionItem;
    
        return $this;
    }

    /**
     * Get descriptionItem
     *
     * @return \LaNet\LaNetBundle\Entity\ProductCategoryDescriptionItem 
     */
    public function getDescriptionItem()
    {
        return $this->descriptionItem;
    }
}