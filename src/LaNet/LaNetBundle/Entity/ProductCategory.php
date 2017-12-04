<?php
namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="LaNet\LaNetBundle\Entity\Repository\ProductCategoryRepository")
 * @ORM\Table(name="product_category")
 */
class ProductCategory
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
     * @ORM\OneToMany(targetEntity="ProductCategoryDescriptionItem", mappedBy="category", cascade={"persist"}, orphanRemoval=true)
     */
    private $descriptionItem;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    protected $product;
    
    /**
     * @ORM\ManyToOne(targetEntity="MasterCategory", inversedBy="productCategory")
     */
    protected $masterCategory;
    
    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="productCategory")
     */
    protected $brand;
    
    /**
     * @ORM\ManyToOne(targetEntity="BrandsCategory", inversedBy="brandCategory")
     */
    protected $brandCategory;
        
    
    /**
     * @ORM\OneToMany(targetEntity="ProductCategory", mappedBy="parent",cascade={"persist"}, orphanRemoval=true)
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="children",cascade={"persist"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;
    

    public function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add product
     *
     * @param \LaNet\LaNetBundle\Entity\Product $product
     * @return ProductCategory
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
     * Add children
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategory $children
     * @return ProductCategory
     */
    public function addChild(\LaNet\LaNetBundle\Entity\ProductCategory $children)
    {
        $this->children[] = $children;
        $children->setParent($this);
        return $this;
    }

    /**
     * Remove children
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategory $children
     */
    public function removeChild(\LaNet\LaNetBundle\Entity\ProductCategory $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategory $parent
     * @return ProductCategory
     */
    public function setParent(\LaNet\LaNetBundle\Entity\ProductCategory $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \LaNet\LaNetBundle\Entity\ProductCategory 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategory $children
     * @return ProductCategory
     */
    public function addChildren(\LaNet\LaNetBundle\Entity\ProductCategory $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategory $children
     */
    public function removeChildren(\LaNet\LaNetBundle\Entity\ProductCategory $children)
    {
        $this->children->removeElement($children);
    }

   
    /**
     * Add descriptionItem
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategoryDescriptionItem $descriptionItem
     * @return ProductCategory
     */
    public function addDescriptionItem(\LaNet\LaNetBundle\Entity\ProductCategoryDescriptionItem $descriptionItem)
    {
        $this->descriptionItem[] = $descriptionItem;
        $descriptionItem->setCategory($this);
        return $this;
    }

    /**
     * Remove descriptionItem
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategoryDescriptionItem $descriptionItem
     */
    public function removeDescriptionItem(\LaNet\LaNetBundle\Entity\ProductCategoryDescriptionItem $descriptionItem)
    {
        $this->descriptionItem->removeElement($descriptionItem);
    }

    /**
     * Get descriptionItem
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDescriptionItem()
    {
        return $this->descriptionItem;
    }

    /**
     * Set brand
     *
     * @param \LaNet\LaNetBundle\Entity\Brand $brand
     * @return ProductCategory
     */
    public function setBrand(\LaNet\LaNetBundle\Entity\Brand $brand = null)
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
    
    /**
     * Set masterCategory
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategory $masterCategory
     * @return ProductCategory
     */
    public function setMasterCategory(\LaNet\LaNetBundle\Entity\MasterCategory $masterCategory = null)
    {
        $this->masterCategory = $masterCategory;
    
        return $this;
    }

    /**
     * Get masterCategory
     *
     * @return \LaNet\LaNetBundle\Entity\MasterCategory 
     */
    public function getMasterCategory()
    {
        return $this->masterCategory;
    }
    
    /**
     * Set masterCategory
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategory $masterCategory
     * @return ProductCategory
     */
    public function setBrandCategory(\LaNet\LaNetBundle\Entity\BrandsCategory $brandCategory = null)
    {
        $this->brandCategory = $brandCategory;
    
        return $this;
    }

    /**
     * Get masterCategory
     *
     * @return \LaNet\LaNetBundle\Entity\MasterCategory 
     */
    public function getBrandCategory()
    {
        return $this->brandCategory;
    }
    
    
    }