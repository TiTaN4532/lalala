<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity
 * @ORM\Table(name="master_category")
 */
class MasterCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
     * @ORM\OneToMany(targetEntity="Master", mappedBy="category")
     */
    private $master;
    
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $name;
    
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->master = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return MasterCategory
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
     * Add master
     *
     * @param \LaNet\LaNetBundle\Entity\Master $master
     * @return MasterCategory
     */
    public function addMaster(\LaNet\LaNetBundle\Entity\Master $master)
    {
        $this->master[] = $master;
    
        return $this;
    }

    /**
     * Remove master
     *
     * @param \LaNet\LaNetBundle\Entity\Master $master
     */
    public function removeMaster(\LaNet\LaNetBundle\Entity\Master $master)
    {
        $this->master->removeElement($master);
    }

    /**
     * Get master
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMaster()
    {
        return $this->master;
    }
}