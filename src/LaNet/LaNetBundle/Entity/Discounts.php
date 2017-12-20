<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity
 * @ORM\Table(name="discounts")
 * @ORM\HasLifecycleCallbacks()
 */
class Discounts extends \LaNet\LaNetBundle\Model\UploadImages
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;
    
    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $startDate;
    
    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $endDate;
         
    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    protected $is_draft;
    
    /**
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $inTop = NULL;
    

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;
   
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;
    
   /**
     * @ORM\ManyToOne(targetEntity="Salon", inversedBy="discounts")
     */
    private $salon;
      
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
     * Set is_draft
     *
     * @return Events
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
     * Set created
     *
     * @param \DateTime $created
     * @return Project
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
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
     * Set description
     *
     * @param string $description
     * @return Events
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
     * Set startDate
     *
     * @param string $startDate
     * @return Events
     */
   
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    
        return $this;
    }

    /**
     * Get startDate
     *
     * @return string 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }
    
    /**
     * Set endDate
     *
     * @param string $endDate
     * @return Events
     */
   
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    
        return $this;
    }

    /**
     * Get endDate
     *
     * @return string 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    
     /**
     * Set inTop
     *
     * @param \DateTime $inTop
     * @return Articles
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
     * Set salon
     *
     * @param \LaNet\LaNetBundle\Entity\Salon $salon
     * @return salon
     */
    public function setSalon(\LaNet\LaNetBundle\Entity\Salon $salon = null)
    {
        $this->salon = $salon;
        return $this;
    }

    /**
     * Get salon
     *
     * @return \LaNet\LaNetBundle\Entity\Salon
     */
    public function getSalon()
    {
        return $this->salon;
    }
}