<?php
namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="LaNet\LaNetBundle\Entity\Repository\BrandRepository")
 * @ORM\Table(name="brand")
 * @ORM\HasLifecycleCallbacks()
 */
class Brand extends \LaNet\LaNetBundle\Model\UploadImages
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
     * @ORM\Column(type="string", length=20)
     */
    protected $validation = 1;
    
    /**
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $inTop = NULL;
    
    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false, separator="-")
     * @ORM\Column(type="string", length=120, unique=true)
     */
    protected $slug;
    
    /**
     * @ORM\Column(type="string", length=100, nullable = true)
     */
    protected $country;
    
    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $link;
    
    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $linkAdd;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $description;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="brand")
     */
    protected $product;
    
    /**
     * @ORM\OneToMany(targetEntity="BrandCategory", mappedBy="brand", cascade={"persist"}, orphanRemoval=true)
     */
    protected $category;
    
     /**
     * @ORM\ManyToMany(targetEntity="BrandsCategory", inversedBy="brand")
     * @ORM\JoinTable(name="brandsS_categories")
     */
    protected $brandsCategory;
    
    /**
     * @ORM\OneToMany(targetEntity="AgancyBrand", mappedBy="brand")
     */
    protected $agancyBrand;
    
     /**
     * @ORM\Column(type="string", length=100, nullable = true)
     */
    protected $phone;
    
    /**
     * @ORM\Column(type="string", length=100, nullable = true)
     */
    protected $mail;
    
    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    protected $is_draft;
    
    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    protected $moderation;
    
         
    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="brandInfo")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
  
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Brand
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
     * Set name
     *
     * @param string $validation
     * @return Brand
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    
        return $this;
    }

    /**
     * Get validation
     *
     * @return string 
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Brand
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
     * Add product
     *
     * @param \LaNet\LaNetBundle\Entity\Product $product
     * @return Brand
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
     * Set image
     *
     * @param string $image
     * @return Brand
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
        return 'uploads/images/brands';
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

    /**
     * Set country
     *
     * @param string $country
     * @return Brand
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Brand
     */
    public function setLink($link)
    {
        $this->link = $link;
    
        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }
    
    /**
     * Set linkAdditional
     *
     * @param string $link
     * @return Brand
     */
    public function setLinkAdd($linkAdd)
    {
        $this->linkAdd = $linkAdd;
    
        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLinkAdd()
    {
        return $this->linkAdd;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Brand
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add category
     *
     * @param \LaNet\LaNetBundle\Entity\BrandCategory $category
     * @return Brand
     */
    public function addCategory(\LaNet\LaNetBundle\Entity\BrandCategory $category)
    {
        $category->setBrand($this);
        $this->category[] = $category;
    
        return $this;
    }

    /**
     * Remove category
     *
     * @param \LaNet\LaNetBundle\Entity\BrandCategory $category
     */
    public function removeCategory(\LaNet\LaNetBundle\Entity\BrandCategory $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add masterCategory
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategory $masterCategory
     * @return Brand
     */
    public function addBrandsCategory(\LaNet\LaNetBundle\Entity\BrandsCategory $brandsCategory)
    {
        $this->brandsCategory[] = $brandsCategory;
    
        return $this;
    }

    /**
     * Remove masterCategory
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategory $masterCategory
     */
    public function removeBrandsCategory(\LaNet\LaNetBundle\Entity\BrandsCategory $brandsCategory)
    {
        $this->brandsCategory->removeElement($brandsCategory);
    }

    /**
     * Get masterCategory
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBrandsCategory()
    {
        return $this->brandsCategory;
    }

    /**
     * Add agancyBrand
     *
     * @param \LaNet\LaNetBundle\Entity\AgancyBrand $agancyBrand
     * @return Brand
     */
    public function addAgancyBrand(\LaNet\LaNetBundle\Entity\AgancyBrand $agancyBrand)
    {
        $this->agancyBrand[] = $agancyBrand;
    
        return $this;
    }

    /**
     * Remove agancyBrand
     *
     * @param \LaNet\LaNetBundle\Entity\AgancyBrand $agancyBrand
     */
    public function removeAgancyBrand(\LaNet\LaNetBundle\Entity\AgancyBrand $agancyBrand)
    {
        $this->agancyBrand->removeElement($agancyBrand);
    }

    /**
     * Get agancyBrand
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAgancyBrand()
    {
        return $this->agancyBrand;
    }
    
    /**
     * Set $phone
     *
     * @param string $phone
     * @return Brand
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }
    /**
     * Set $mail
     *
     * @param string $mail
     * @return Brand
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    
        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }
    
     /**
     * Set is_draft
     *
     * @return Brand
     */
    public function setIsDraft($value)
    {
        $this->is_draft = $value;
    
        return $this;
    }

    /**
     * Get is_draft
     *
     * @return boolean 
     */
    public function getIsDraft()
    {
        return $this->is_draft;
    }
    
     /**
     * Set moderation
     *
     * @return Brand
     */
    public function setModeration($moderation)
    {
        $this->moderation = $moderation;
    
        return $this;
    }

    /**
     * Get moderation
     *
     * @return boolean 
     */
    public function getModeration()
    {
        return $this->moderation;
    }
    
    /**
     * Set inTop
     *
     * @param \DateTime $inTop
     * @return Brand
     */
    public function setinTop($inTop = NULL)
    {
        $this->inTop = $inTop;
    
        return $this;
    }

    /**
     * Get inTop
     *
     * @return \DateTime 
     */
    public function getinTop()
    {
        return $this->inTop;
    }
    
    /**
     * Set user
     *
     * @param \LaNet\LaNetBundle\Entity\User $user
     * @return Master
     */
    public function setUser(\LaNet\LaNetBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \LaNet\LaNetBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

}