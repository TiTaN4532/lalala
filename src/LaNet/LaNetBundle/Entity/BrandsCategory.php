<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="brands_category")
 * @ORM\HasLifecycleCallbacks()
 */
class BrandsCategory extends \LaNet\LaNetBundle\Model\UploadImages
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

        
    /**
     * @ORM\ManyToMany(targetEntity="Brand", mappedBy="brandsCategory")
     */
    private $brand;
    
    /**
     * @ORM\ManyToMany(targetEntity="School", mappedBy="brandsCategory")
     */
    private $school;
    
    /**
     * @ORM\ManyToMany(targetEntity="Salon", mappedBy="brandsCategory")
     */
    private $salon;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;
       
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="brandCategory")
     */
    protected $product;
    
    /**
     * @ORM\OneToMany(targetEntity="ProductCategory", mappedBy="brandCategory")
     */
    protected $productCategory;
    
    
   
    /**
     * Constructor
     */
    
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
     * Add product
     *
     * @param \LaNet\LaNetBundle\Entity\Product $product
     * @return MasterCategory
     */
    
    public function addProductCategoty(\LaNet\LaNetBundle\Entity\Product $productCategory)
    {
        $this->productCategory[] = $productCategory;
    
        return $this;
    }

    /**
     * Remove product
     *
     * @param \LaNet\LaNetBundle\Entity\Product $product
     */
    public function removeProductCategory(\LaNet\LaNetBundle\Entity\Product $productCategory)
    {
        $this->productCategory->removeElement($productCategory);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductCategory()
    {
        return $this->productCategory;
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
    
    /**
     * Add school
     *
     * @param \LaNet\LaNetBundle\Entity\School $school
     * @return MasterCategory
     */
    public function addSchool(\LaNet\LaNetBundle\Entity\School $school)
    {
        $this->school[] = $school;
    
        return $this;
    }

    /**
     * Remove school
     *
     * @param \LaNet\LaNetBundle\Entity\School $school
     */
    public function removeSchool(\LaNet\LaNetBundle\Entity\School $school)
    {
        $this->school->removeElement($school);
    }

    /**
     * Get school
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchool()
    {
        return $this->school;
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
     * Set image
     *
     * @param string $image
     * @return Mentor
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
    
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/images/brands_category';
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
            unlink($file);
        }
    }

    
    
}