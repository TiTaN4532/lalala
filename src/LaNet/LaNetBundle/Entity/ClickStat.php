<?php
namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * ClickStat
 * @ORM\Entity
 * @ORM\Table(name="clickStat")
 * @ORM\HasLifecycleCallbacks()
 */
class ClickStat extends \LaNet\LaNetBundle\Model\UploadImages
{
  /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
               
     /**
     * @ORM\Column(type="integer")
     */
    protected $id_num;
    
     /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;
   
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Banners", inversedBy="clickStat")
     */
    private $banners;
      
    
       
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
     * Set id_num
     *
     * @param integer $id_num
     * @return ClickStat
     */
    public function setIdNum($id_num)
    {
        $this->id_num = $id_num;
    
        return $this;
    }

    /**
     * Get id_num
     *
     * @return integer 
     */
   
    public function getIdNum()
    {
        return $this->id_num;
    }
    
    
    public function __construct() 
     {
        $this->banners = new \Doctrine\Common\Collections\ArrayCollection();
     }
             
   
    /**
     * Set banners
     *
     * @param \LaNet\LaNetBundle\Entity\Banners $banners
     * @return ClickStat
     */
    public function setBanners(\LaNet\LaNetBundle\Entity\Banners $banners = null)
    {
        $this->banners = $banners;
    
        return $this;
    }

    /**
     * Get banners
     *
     * @return \LaNet\LaNetBundle\Entity\Banners 
     */
    public function getBanners()
    {
        return $this->banners;
    }

    
}