<?php

namespace  LaNet\LaNetBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToOne(targetEntity="Master", mappedBy="user", orphanRemoval=true)
     */
    private $masterInfo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $is_master;
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Set masterInfo
     *
     * @param \LaNet\LaNetBundle\Entity\Master $masterInfo
     * @return User
     */
    public function setMasterInfo(\LaNet\LaNetBundle\Entity\Master $masterInfo = null)
    {
        $this->masterInfo = $masterInfo;
    
        return $this;
    }

    /**
     * Get masterInfo
     *
     * @return \LaNet\LaNetBundle\Entity\Master 
     */
    public function getMasterInfo()
    {
        return $this->masterInfo;
    }

    /**
     * Set is_master
     *
     * @param boolean $isMaster
     * @return User
     */
    public function setIsMaster($isMaster)
    {
        $this->is_master = $isMaster;
    
        return $this;
    }

    /**
     * Get is_master
     *
     * @return boolean 
     */
    public function getIsMaster()
    {
        return $this->is_master;
    }
}