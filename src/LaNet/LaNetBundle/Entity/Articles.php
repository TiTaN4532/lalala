<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="LaNet\LaNetBundle\Entity\Repository\ArticlesRepository")
 * @ORM\Table(name="articles")
 * @ORM\HasLifecycleCallbacks()
 */
class Articles extends \LaNet\LaNetBundle\Model\UploadImages
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
    protected $title;

    /**
     * @Gedmo\Slug(fields={"title"}, updatable=false, separator="-")
     * @ORM\Column(type="string", length=120, unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="text")
     */
    protected $post;
    
    /**
     * @ORM\Column(type="text", nullable = true)
     */
    protected $video;
    
     /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="article", cascade={"persist"}, orphanRemoval=true)
     */
    protected $portfolio;
        
    
    /**
     * @ORM\Column(type="string")
     */
    protected $description;
         
    /**
     * @ORM\Column(type="string")
     */
    protected $type;
    
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
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;
    
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
     * Set title
     *
     * @param string $title
     * @return Events
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Events
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
     * Set post
     *
     * @param string $post
     * @return Events
     */
    public function setPost($post)
    {
        $this->post = $post;
    
        return $this;
    }

    /**
     * Get post
     *
     * @return string 
     */
    public function getPost()
    {
        return $this->post;
    }
    
    /**
     * Set video
     *
     * @param string $video
     * @return Events
     */
    public function setVideo($video)
    {
        $this->video = $video;
    
        return $this;
    }

    /**
     * Get video
     *
     * @return string 
     */
    public function getVideo()
    {
        return $this->video;
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
     * Set post
     *
     * @param string $type
     * @return Articles
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
     * Add portfolio
     *
     * @param \LaNet\LaNetBundle\Entity\Image $portfolio
     * @return Aticles
     */
    public function addPortfolio(\LaNet\LaNetBundle\Entity\Image $portfolio)
    {
        $portfolio->setArticle($this);
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return Project
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
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
        return 'uploads/images/articles';
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
}