<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="LaNet\LaNetBundle\Entity\Repository\MasterRepository")
 * @ORM\Table(name="master")
 * @ORM\HasLifecycleCallbacks()
 */
class Master extends \LaNet\LaNetBundle\Model\UploadImages
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable = true)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=100, nullable = true)
     */
    protected $lastName;
    
    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $adress;
    
    /**
     * @ORM\Column(type="string", length=50, nullable = true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $saloon;
    
    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $type;
    
    /**
     * @ORM\Column(type="string", length=50, nullable = true)
     */
    protected $image;
    
    /**
     * @ORM\Column(type="integer", nullable = true)
     */
    protected $experience;
    
    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $usedCosmetics;
    
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="master", cascade={"persist"}, orphanRemoval=true)
     */
    protected $portfolio;
    
    /**
     * @ORM\ManyToOne(targetEntity="MasterCategory", inversedBy="master")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;
    
    /**
     * @ORM\OneToMany(targetEntity="MasterCategoryServicePrice", mappedBy="master", cascade={"persist"}, orphanRemoval=true)
     */
    protected $services;
    
    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="masterInfo")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->portfolio = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set firstName
     *
     * @param string $firstName
     * @return Master
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Master
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set adress
     *
     * @param string $adress
     * @return Master
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
    
        return $this;
    }

    /**
     * Get adress
     *
     * @return string 
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Master
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
     * Set saloon
     *
     * @param string $saloon
     * @return Master
     */
    public function setSaloon($saloon)
    {
        $this->saloon = $saloon;
    
        return $this;
    }

    /**
     * Get saloon
     *
     * @return string 
     */
    public function getSaloon()
    {
        return $this->saloon;
    }
    
     /**
     * Set experience
     *
     * @param string $experience
     * @return Master
     */
    public function setExperience($value)
    {
        $this->experience = $value;
    
        return $this;
    }

    /**
     * Get experience
     *
     * @return integer 
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Master
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
     * Set image
     *
     * @param string $image
     * @return Master
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
     * Add portfolio
     *
     * @param \LaNet\LaNetBundle\Entity\Image $portfolio
     * @return Master
     */
    public function addPortfolio(\LaNet\LaNetBundle\Entity\Image $portfolio)
    {
        $portfolio->setMaster($this);
        $this->portfolio[] = $portfolio;
    
        return $this;
    }

    /**
     * Remove portfolio
     *
     * @param \LaNet\LaNetBundle\Entity\Image $portfolio
     */
    public function removePortfolio(\LaNet\LaNetBundle\Entity\Image $portfolio)
    {
        $this->portfolio->removeElement($portfolio);
    }

    /**
     * Get portfolio
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }

    /**
     * Set category
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategory $category
     * @return Master
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
     * Add services
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategoryServicePrice $services
     * @return Master
     */
    public function addService(\LaNet\LaNetBundle\Entity\MasterCategoryServicePrice $services)
    {
        $services->setMaster($this);
        $this->services[] = $services;
    
        return $this;
    }

    /**
     * Remove services
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategoryServicePrice $services
     */
    public function removeService(\LaNet\LaNetBundle\Entity\MasterCategoryServicePrice $services)
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
    
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/images/master';
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
     * Set usedCosmetics
     *
     * @param string $usedCosmetics
     * @return Master
     */
    public function setUsedCosmetics($usedCosmetics)
    {
        $this->usedCosmetics = $usedCosmetics;
    
        return $this;
    }

    /**
     * Get usedCosmetics
     *
     * @return string 
     */
    public function getUsedCosmetics()
    {
        return $this->usedCosmetics;
    }
}