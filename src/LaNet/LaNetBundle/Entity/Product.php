<?php
namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="LaNet\LaNetBundle\Entity\Repository\ProductRepository")
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks()
 */
class Product extends \LaNet\LaNetBundle\Model\UploadImages
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
     * @ORM\Column(type="text")
     */
    protected $description;
    
    /**
     * @ORM\Column(type="text", nullable = true)
     */
    protected $contraindications;
    
     /**
     * @ORM\Column(type="text", nullable = true)
     */
    protected $application;
    
    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="product")
     */
    protected $category;
    
    /**
     * @ORM\ManyToOne(targetEntity="MasterCategory", inversedBy="product")
     */
    protected $masterCategory;
    
    /**
     * @ORM\ManyToOne(targetEntity="BrandsCategory", inversedBy="product")
     */
    protected $brandCategory;
    
    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="product")
     */
    protected $brand;
    
    /**
     * @ORM\OneToMany(targetEntity="ProductCategoryDescriptionName", mappedBy="product", orphanRemoval=true)
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
     * @return Product
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
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set category
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategory $category
     * @return Product
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
     * Set brand
     *
     * @param \LaNet\LaNetBundle\Entity\Brand $brand
     * @return Product
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
    
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/images/product';
    }
        
 
     /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate() 
     */
    public function prePersist()
    {
      if (null !== $this->file) {
         // do whatever you want to generate a unique name
        $this->image = time().'.'.$this->file->guessExtension();
      }
    }
     
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    { 
       if (null === $this->file) {
            return;
       }
       if(is_object($this->file))
       {  
          // if there is an error when moving the file, an exception will
          // be automatically thrown by move(). This will properly prevent
          // the entity from being persisted to the database on error
          $this->file->move($this->getUploadRootDir(), $this->image);

          // check if we have an old image
          if (isset($this->temp)) {
              // delete the old image
              if(file_exists($this->getUploadRootDir().'/'.$this->temp))
                 unlink($this->getUploadRootDir().'/'.$this->temp);
              // clear the temp image path
              $this->temp = null;
          }
          $this->file = null;
       }
    }
    
     /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            if(file_exists($file))
                unlink($file);
        }
    }

    /**
     * Set masterCategory
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategory $masterCategory
     * @return Product
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
     * @return Product
     */
    public function setBrandsCategory(\LaNet\LaNetBundle\Entity\BrandsCategory $brandCategory = null)
    {
        $this->brandCategory = $brandCategory;
    
        return $this;
    }

    /**
     * Get masterCategory
     *
     * @return \LaNet\LaNetBundle\Entity\MasterCategory 
     */
    public function getBrandsCategory()
    {
        return $this->brandCategory;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->descriptionName = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add descriptionName
     *
     * @param \LaNet\LaNetBundle\Entity\ProductCategoryDescriptionName $descriptionName
     * @return Product
     */
    public function addDescriptionName(\LaNet\LaNetBundle\Entity\ProductCategoryDescriptionName $descriptionName)
    {
        $this->descriptionName[] = $descriptionName;
    
        return $this;
    }
    
    public function hasDescriptionItem(\LaNet\LaNetBundle\Entity\ProductCategoryDescriptionItem $descriptionItem)
    {
        foreach ($this->descriptionName as $value) {
            if($value->getDescriptionItem() == $descriptionItem)
                return $value;
        }
        return false;
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

    /**
     * Set contraindications
     *
     * @param string $contraindications
     * @return Product
     */
    public function setContraindications($contraindications)
    {
        $this->contraindications = $contraindications;
    
        return $this;
    }

    /**
     * Get contraindications
     *
     * @return string 
     */
    public function getContraindications()
    {
        return $this->contraindications;
    }


    /**
     * Set application
     *
     * @param string $application
     * @return Product
     */
    public function setApplication($application)
    {
        $this->application = $application;
    
        return $this;
    }

    /**
     * Get application
     *
     * @return string 
     */
    public function getApplication()
    {
        return $this->application;
    }
}