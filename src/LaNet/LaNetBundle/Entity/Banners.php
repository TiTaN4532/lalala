<?php
namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="LaNet\LaNetBundle\Entity\Repository\BannersRepository")
 * @ORM\Table(name="banners")
 * @ORM\HasLifecycleCallbacks()
 */
class Banners extends \LaNet\LaNetBundle\Model\UploadImages
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
     * @ORM\Column(type="string")
     */
    protected $link;
    
     /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $click;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $priority;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $group_id;
    
    
    
    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    protected $is_draft;
        
    /**
     * @ORM\OneToMany(targetEntity="Banners", mappedBy="clickStat", cascade={"all"}, orphanRemoval=true  )
     */
    private $clickStat;
    
   
       
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
     * @return Banners
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
     * @return Banners
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

     /**
     * Set click
     *
     * @param string $experience
     * @return Banners
     */
    public function setClick($value)
    {
        $this->click = $value;
    
        return $this;
    }

    /**
     * Get click
     *
     * @return integer 
     */
    public function getClick()
    {
        
        return $this->click;
        
    }
    
     /**
     * Set click
     *
     * @param string $experience
     * @return Banners
     */
    public function setPriority($value)
    {
        
        $this->priority = $value;
    
        return $this;
    }

    /**
     * Get click
     *
     * @return integer 
     */
    public function getPriority()
    {
        
        return $this->priority;
        
    }
     /**
     * Set group_id
     *
     * @param string $group_id
     * @return Banners
     */
    public function setGroupId($value)
    {
        
        $this->group_id = $value;
    
        return $this;
    }

    /**
     * Get group_id
     *
     * @return integer 
     */
    public function getGroupId()
    {
        
        return $this->group_id;
        
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
        return 'uploads/images/banners';
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
     * Set link
     *
     * @param string $link
     * @return Banners
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

    
     public function __construct() 
     {
        $this->clickStat = new \Doctrine\Common\Collections\ArrayCollection();
     }
    

    /**
     * Add clickStat
     *
     * @param \LaNet\LaNetBundle\Entity\ClickStat $clickStat
     * @return Banners
     */
    public function addClickStat(\LaNet\LaNetBundle\Entity\ClickStat $clickStat)
    {
        $this->clickStat[] = $clickStat;
    
        return $this;
    }

    /**
     * Remove clickStat
     *
     * @param \LaNet\LaNetBundle\Entity\ClickStat $clickStat
     */
    public function removeClickStat(\LaNet\LaNetBundle\Entity\ClickStat $clickStat)
    {
        $this->clickStat->removeElement($clickStat);
    }

    /**
     * Get clickStat
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClickStat()
    {
        return $this->clickStat;
    }
    
    /**
     * Set is_draft
     *
     * @return Banners
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
}