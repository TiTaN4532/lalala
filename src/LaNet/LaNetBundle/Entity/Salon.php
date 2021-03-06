<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="LaNet\LaNetBundle\Entity\Repository\SalonRepository")
 * @ORM\Table(name="salon_info")
 * @ORM\HasLifecycleCallbacks()
 */
class Salon extends \LaNet\LaNetBundle\Model\UploadImages
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
    protected $name;
    
    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $link;

    /**
     * @ORM\Column(type="string", length=50, nullable = true)
     */
    protected $image;
    
    /**
     * @ORM\ManyToMany(targetEntity="MasterCategory", inversedBy="salon")
     * @ORM\JoinTable(name="salons_categories")
     */
    protected $category;
    
    /**
     * @ORM\OneToOne(targetEntity="Location", mappedBy="salonInfo", cascade={"persist"}, orphanRemoval=true)
     */
    protected $location;

    
    /**
     * @ORM\OneToMany(targetEntity="SalonWorkShcedule", mappedBy="salon", cascade={"persist"}, orphanRemoval=true)
     */
    protected $schedule;
    
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="salon", cascade={"persist"}, orphanRemoval=true)
     */
    protected $portfolio;
    
    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="consumerInfo")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    /**
     * @ORM\OneToMany(targetEntity="Service", mappedBy="salon", cascade={"persist"}, orphanRemoval=true)
     */
    protected $services;

    
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
     * Set nmae
     *
     * @param string $nmae
     * @return Salon
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
        return 'uploads/images/salons';
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
     * Get category
     *
     * @return \LaNet\LaNetBundle\Entity\SalonCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add category
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategory $category
     * @return Salon
     */
    public function addCategory(\LaNet\LaNetBundle\Entity\MasterCategory $category)
    {
        $this->category[] = $category;
    
        return $this;
    }

    /**
     * Remove category
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategory $category
     */
    public function removeCategory(\LaNet\LaNetBundle\Entity\MasterCategory $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Set location
     *
     * @param \LaNet\LaNetBundle\Entity\Location $location
     * @return Salon
     */
    public function setLocation(\LaNet\LaNetBundle\Entity\Location $location = null)
    {
        $location->setSalonInfo($this);
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return \LaNet\LaNetBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add schedule
     *
     * @param \LaNet\LaNetBundle\Entity\SalonWorkShcedule $schedule
     * @return Salon
     */
    public function addSchedule(\LaNet\LaNetBundle\Entity\SalonWorkShcedule $schedule)
    {
        $this->schedule[] = $schedule;
    
        return $this;
    }

    /**
     * Remove schedule
     *
     * @param \LaNet\LaNetBundle\Entity\SalonWorkShcedule $schedule
     */
    public function removeSchedule(\LaNet\LaNetBundle\Entity\SalonWorkShcedule $schedule)
    {
        $this->schedule->removeElement($schedule);
    }

    /**
     * Get schedule
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Add portfolio
     *
     * @param \LaNet\LaNetBundle\Entity\Image $portfolio
     * @return Salon
     */
    public function addPortfolio(\LaNet\LaNetBundle\Entity\Image $portfolio)
    {
        $portfolio->setSalon($this);
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
     * Add services
     *
     * @param \LaNet\LaNetBundle\Entity\Service $services
     * @return Salon
     */
    public function addService(\LaNet\LaNetBundle\Entity\Service $services)
    {
        $services->setSalon($this);
        $this->services[] = $services;
    
        return $this;
    }

    /**
     * Remove services
     *
     * @param \LaNet\LaNetBundle\Entity\Service $services
     */
    public function removeService(\LaNet\LaNetBundle\Entity\Service $services)
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
     * Set link
     *
     * @param string $link
     * @return Salon
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
}