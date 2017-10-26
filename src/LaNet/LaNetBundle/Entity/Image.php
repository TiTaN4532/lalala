<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="images")
 * @ORM\HasLifecycleCallbacks()
 */
class Image extends \LaNet\LaNetBundle\Model\UploadImages
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
     * @ORM\ManyToOne(targetEntity="Master", inversedBy="portfolio")
     * @ORM\JoinColumn(name="master_id", referencedColumnName="id")
     */
    private $master;
    
   /**
     * @ORM\ManyToOne(targetEntity="Articles", inversedBy="portfolio")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    private $article;
    
   /**
     * @ORM\ManyToOne(targetEntity="School", inversedBy="portfolio")
     */
    private $school;
    
   /**
     * @ORM\ManyToOne(targetEntity="Salon", inversedBy="portfolio")
     */
    private $salon;
    
   /**
     * @ORM\ManyToOne(targetEntity="Agancy", inversedBy="portfolio")
     */
    private $agancy;
    
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $image;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $description;
    

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
     * Set image
     *
     * @param string $image
     * @return Image
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
     * Set article
     *
     * @param \LaNet\LaNetBundle\Entity\Articles $article
     * @return Image
     */
    public function setArticle(\LaNet\LaNetBundle\Entity\Articles $article = null)
    {
        $this->article = $article;
    
        return $this;
    }

    /**
     * Get article
     *
     * @return \LaNet\LaNetBundle\Entity\Articles 
     */
    public function getArticle()
    {
        return $this->article;
    }
    /**
     * Set master
     *
     * @param \LaNet\LaNetBundle\Entity\Master $master
     * @return Image
     */
    public function setMaster(\LaNet\LaNetBundle\Entity\Master $master = null)
    {
        $this->master = $master;
    
        return $this;
    }

    /**
     * Get master
     *
     * @return \LaNet\LaNetBundle\Entity\Master 
     */
    public function getMaster()
    {
        return $this->master;
    }
    
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/images/portfolio';
    }
        
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate() 
     */
    public function prePersist()
    {
      if (null !== $this->file) {
        $fileName = $this->file->getClientOriginalName();
       $this->image = substr($fileName, 0, strrpos($fileName, '.')).'_'.time().'_'.mt_rand().'.'.$this->file->guessExtension();
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
     * Set description
     *
     * @param string $description
     * @return Image
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
     * Set salon
     *
     * @param \LaNet\LaNetBundle\Entity\Salon $salon
     * @return Image
     */
    public function setSchool(\LaNet\LaNetBundle\Entity\School $school = null)
    {
        $this->school = $school;
    
        return $this;
    }

    /**
     * Get salon
     *
     * @return \LaNet\LaNetBundle\Entity\School 
     */
    public function getSchool()
    {
        return $this->school;
    }
    
    /**
     * Set salon
     *
     * @param \LaNet\LaNetBundle\Entity\Salon $salon
     * @return Image
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

    /**
     * Set agancy
     *
     * @param \LaNet\LaNetBundle\Entity\Agancy $agancy
     * @return Image
     */
    public function setAgancy(\LaNet\LaNetBundle\Entity\Agancy $agancy = null)
    {
        $this->agancy = $agancy;
    
        return $this;
    }

    /**
     * Get agancy
     *
     * @return \LaNet\LaNetBundle\Entity\Agancy 
     */
    public function getAgancy()
    {
        return $this->agancy;
    }
}