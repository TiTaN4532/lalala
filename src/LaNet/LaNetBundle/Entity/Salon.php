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
     * @ORM\Column(type="string", length=50, nullable = true)
     */
    protected $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="SalonCategory", inversedBy="salons")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;
    
    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="consumerInfo")
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
     * Set category
     *
     * @param \LaNet\LaNetBundle\Entity\SalonCategory $category
     * @return Salon
     */
    public function setCategory(\LaNet\LaNetBundle\Entity\SalonCategory $category = null)
    {
        $this->category = $category;
    
        return $this;
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
}