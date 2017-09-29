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
     * @ORM\Column(type="string", nullable = true)
     */
    protected $gender;
    
    /**
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $inTop = NULL;
    
    /**
     * @ORM\Column(type="array")
     */
    protected $serviceType;
    
    /**
     * @ORM\Column(type="text", nullable = true)
     */
    protected $birthday;
    
    /**
     * @ORM\Column(type="text", nullable = true)
     */
    protected $startWork;
    
    /**
     * @ORM\Column(type="string", length=50, nullable = true)
     */
    protected $image;
    
    /**
     * @ORM\Column(type="integer", nullable = true)
     */
    protected $experience;
    
    /**
     * @ORM\Column(type="text", nullable = true)
     */
    protected $usedCosmetics;
    
    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $link;
    
    /**
     * @ORM\Column(type="text", nullable = true)
     */
    protected $education;
    
    /**
     * @ORM\Column(type="text", nullable = true)
     */
    protected $competitions;
    
    /**
     * @ORM\Column(type="text", nullable = true)
     */
    protected $hobby;
    
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="master", cascade={"persist"}, orphanRemoval=true)
     */
    protected $portfolio;
    
    /**
     * @ORM\OneToOne(targetEntity="Location", mappedBy="masterInfo", cascade={"persist"}, orphanRemoval=true)
     */
    protected $location;
    
    /**
     * @ORM\ManyToMany(targetEntity="MasterCategory", inversedBy="master")
     * @ORM\JoinTable(name="masters_categories")
     */
    protected $category;
    
    /**
     * @ORM\OneToMany(targetEntity="MasterWorkShcedule", mappedBy="master", cascade={"persist"}, orphanRemoval=true)
     */
    protected $schedule;
    
    /**
     * @ORM\OneToMany(targetEntity="Service", mappedBy="master", cascade={"persist"}, orphanRemoval=true)
     */
    protected $services;
    
    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="masterInfo")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    
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

    /**
     * Set gender
     *
     * @param string $gender
     * @return Master
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set serviceType
     *
     * @param integer $serviceType
     * @return Master
     */
    public function setServiceType($serviceType)
    {
        $this->serviceType = $serviceType;
    
        return $this;
    }

    /**
     * Get serviceType
     *
     * @return integer 
     */
    public function getServiceType()
    {
        return $this->serviceType;
    }

    


    /**
     * Set location
     *
     * @param \LaNet\LaNetBundle\Entity\Location $location
     * @return Master
     */
    public function setLocation(\LaNet\LaNetBundle\Entity\Location $location = null)
    {
        $location->setMasterInfo($this);
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
     * Add category
     *
     * @param \LaNet\LaNetBundle\Entity\MasterCategory $category
     * @return Master
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
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategory()
    {
        return $this->category;
    }

  
    /**
     * Set education
     *
     * @param string $education
     * @return Master
     */
    public function setEducation($education)
    {
        $this->education = $education;
    
        return $this;
    }

    /**
     * Get education
     *
     * @return string 
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set competitions
     *
     * @param string $competitions
     * @return Master
     */
    public function setCompetitions($competitions)
    {
        $this->competitions = $competitions;
    
        return $this;
    }

    /**
     * Get competitions
     *
     * @return string 
     */
    public function getCompetitions()
    {
        return $this->competitions;
    }

    /**
     * Set hobby
     *
     * @param string $hobby
     * @return Master
     */
    public function setHobby($hobby)
    {
        $this->hobby = $hobby;
    
        return $this;
    }

    /**
     * Get hobby
     *
     * @return string 
     */
    public function getHobby()
    {
        return $this->hobby;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->portfolio = new \Doctrine\Common\Collections\ArrayCollection();
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
        $this->schedule = new \Doctrine\Common\Collections\ArrayCollection();
        $this->services = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add schedule
     *
     * @param \LaNet\LaNetBundle\Entity\MasterWorkShcedule $schedule
     * @return Master
     */
    public function addSchedule(\LaNet\LaNetBundle\Entity\MasterWorkShcedule $schedule)
    {
        $this->schedule[] = $schedule;
    
        return $this;
    }

    /**
     * Remove schedule
     *
     * @param \LaNet\LaNetBundle\Entity\MasterWorkShcedule $schedule
     */
    public function removeSchedule(\LaNet\LaNetBundle\Entity\MasterWorkShcedule $schedule)
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
     * Set inTop
     *
     * @param \DateTime $inTop
     * @return Master
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
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Master
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    
        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set startWork
     *
     * @param \DateTime $startWork
     * @return Master
     */
    public function setStartWork($startWork)
    {
        $this->startWork = $startWork;
    
        return $this;
    }

    /**
     * Get startWork
     *
     * @return \DateTime 
     */
    public function getStartWork()
    {
        return $this->startWork;
    }

    /**
     * Add services
     *
     * @param \LaNet\LaNetBundle\Entity\Service $services
     * @return Master
     */
    public function addService(\LaNet\LaNetBundle\Entity\Service $services)
    {
        $services->setMaster($this);
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
     * @return Master
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