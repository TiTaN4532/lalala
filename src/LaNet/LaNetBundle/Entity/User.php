<?php

namespace  LaNet\LaNetBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaNet\LaNetBundle\Entity as LaEntity;


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
     * @ORM\OneToOne(targetEntity="Consumer", mappedBy="user", orphanRemoval=true)
     */
    private $consumerInfo;
    
    /**
     * @ORM\OneToOne(targetEntity="Salon", mappedBy="user", orphanRemoval=true)
     */
    private $salonInfo;
    
    /**
     * @ORM\OneToOne(targetEntity="Agancy", mappedBy="user", orphanRemoval=true)
     */
    private $agancyInfo;
    
    /**
     * @ORM\OneToOne(targetEntity="Shop", mappedBy="user", orphanRemoval=true)
     */
    private $shopInfo;
    
    /**
     * @ORM\OneToOne(targetEntity="SchoolCenter", mappedBy="user", orphanRemoval=true)
     */
    private $schoolCenterInfo;


    
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

    public function setUserInfo($userInfo)
    {
        if ($userInfo instanceof LaEntity\Master) {
            $this->masterInfo = $userInfo;
        } elseif ($userInfo instanceof LaEntity\Consumer) {
            $this->consumerInfo = $userInfo;
        } elseif ($userInfo instanceof LaEntity\Salon) {
            $this->salonInfo = $userInfo;
        } elseif ($userInfo instanceof LaEntity\Agancy) {
            $this->agancyInfo = $userInfo;
        } elseif ($userInfo instanceof LaEntity\Shop) {
            $this->shopInfo = $userInfo;
        } elseif ($userInfo instanceof LaEntity\SchoolCenter) {
            $this->schoolCenterInfo = $userInfo;
        }
        
        return $this;
    }


    public function getUserInfo() {
        if ($this->hasRole('ROLE_MASTER')) {
            return $this->masterInfo;
        } elseif ($this->hasRole('ROLE_CONSUMER')) {
            return $this->consumerInfo;
        } elseif ($this->hasRole('ROLE_SALON')) {
            return $this->salonInfo;
        } elseif ($this->hasRole('ROLE_AGANCY')) {
            return $this->agancyInfo;
        } elseif ($this->hasRole('ROLE_SHOP')) {
            return $this->shopInfo;
        } elseif ($this->hasRole('ROLE_SCHOOL_CENTER')) {
            return $this->schoolCenterInfo;
        }
    }
}