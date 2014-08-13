<?php

namespace  LaNet\LaNetBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaNet\LaNetBundle\Entity as LaEntity;


/**
 * @ORM\Entity(repositoryClass="LaNet\LaNetBundle\Entity\Repository\UserRepository")
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
     * @ORM\OneToOne(targetEntity="Master", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $masterInfo;
    
    /**
     * @ORM\OneToOne(targetEntity="Consumer", mappedBy="user", cascade={"persist"}, orphanRemoval=true)
     */
    private $consumerInfo;
    
    /**
     * @ORM\OneToOne(targetEntity="Salon", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $salonInfo;
    
    /**
     * @ORM\OneToOne(targetEntity="Agancy", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $agancyInfo;
    
    /**
     * @ORM\OneToOne(targetEntity="Shop", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $shopInfo;
    
    /**
     * @ORM\OneToOne(targetEntity="SchoolCenter", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $schoolCenterInfo;


    /**
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="user", cascade={"persist"}, orphanRemoval=true)
     */
    protected $phone;
    
    /**
     * @ORM\OneToMany(targetEntity="Mail", mappedBy="user", cascade={"persist"}, orphanRemoval=true)
     */
    protected $mail;
    
    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    protected $showPhone;
    
    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    protected $showMail;
    
    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    protected $termsConditions;
    
    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    protected $newsNotify;
    
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

    
     public function setEmail($email)
    {
        $this->setUsername($email);
        return parent::setEmail($email);
    }

    /**
     * Set the canonical email.
     *
     * @param string $emailCanonical
     * @return User
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->setUsernameCanonical($emailCanonical);

        return parent::setEmailCanonical($emailCanonical);
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
        $userInfo->setUser($this);
        
        return $this;
    }


    public function getUserInfo() {
        if ($this->hasRole('ROLE_SPECIALIST')) {
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
     * Set consumerInfo
     *
     * @param \LaNet\LaNetBundle\Entity\Consumer $consumerInfo
     * @return User
     */
    public function setConsumerInfo(\LaNet\LaNetBundle\Entity\Consumer $consumerInfo = null)
    {
        $this->consumerInfo = $consumerInfo;
        return $this;
    }

    /**
     * Get consumerInfo
     *
     * @return \LaNet\LaNetBundle\Entity\Consumer 
     */
    public function getConsumerInfo()
    {
        return $this->consumerInfo;
    }

    /**
     * Set salonInfo
     *
     * @param \LaNet\LaNetBundle\Entity\Salon $salonInfo
     * @return User
     */
    public function setSalonInfo(\LaNet\LaNetBundle\Entity\Salon $salonInfo = null)
    {
        $this->salonInfo = $salonInfo;
    
        return $this;
    }

    /**
     * Get salonInfo
     *
     * @return \LaNet\LaNetBundle\Entity\Salon 
     */
    public function getSalonInfo()
    {
        return $this->salonInfo;
    }

    /**
     * Set agancyInfo
     *
     * @param \LaNet\LaNetBundle\Entity\Agancy $agancyInfo
     * @return User
     */
    public function setAgancyInfo(\LaNet\LaNetBundle\Entity\Agancy $agancyInfo = null)
    {
        $this->agancyInfo = $agancyInfo;
    
        return $this;
    }

    /**
     * Get agancyInfo
     *
     * @return \LaNet\LaNetBundle\Entity\Agancy 
     */
    public function getAgancyInfo()
    {
        return $this->agancyInfo;
    }

    /**
     * Set shopInfo
     *
     * @param \LaNet\LaNetBundle\Entity\Shop $shopInfo
     * @return User
     */
    public function setShopInfo(\LaNet\LaNetBundle\Entity\Shop $shopInfo = null)
    {
        $this->shopInfo = $shopInfo;
    
        return $this;
    }

    /**
     * Get shopInfo
     *
     * @return \LaNet\LaNetBundle\Entity\Shop 
     */
    public function getShopInfo()
    {
        return $this->shopInfo;
    }

    /**
     * Set schoolCenterInfo
     *
     * @param \LaNet\LaNetBundle\Entity\SchoolCenter $schoolCenterInfo
     * @return User
     */
    public function setSchoolCenterInfo(\LaNet\LaNetBundle\Entity\SchoolCenter $schoolCenterInfo = null)
    {
        $this->schoolCenterInfo = $schoolCenterInfo;
    
        return $this;
    }

    /**
     * Get schoolCenterInfo
     *
     * @return \LaNet\LaNetBundle\Entity\SchoolCenter 
     */
    public function getSchoolCenterInfo()
    {
        return $this->schoolCenterInfo;
    }

    /**
     * Add phone
     *
     * @param \LaNet\LaNetBundle\Entity\Phone $phone
     * @return User
     */
    public function addPhone(\LaNet\LaNetBundle\Entity\Phone $phone)
    {
        $phone->setUser($this);
        $this->phone[] = $phone;
    
        return $this;
    }

    /**
     * Remove phone
     *
     * @param \LaNet\LaNetBundle\Entity\Phone $phone
     */
    public function removePhone(\LaNet\LaNetBundle\Entity\Phone $phone)
    {
        
        $this->phone->removeElement($phone);
    }

    /**
     * Get phone
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add mail
     *
     * @param \LaNet\LaNetBundle\Entity\Mail $mail
     * @return User
     */
    public function addMail(\LaNet\LaNetBundle\Entity\Mail $mail)
    {
        $mail->setUser($this);
        $this->mail[] = $mail;
    
        return $this;
    }

    /**
     * Remove mail
     *
     * @param \LaNet\LaNetBundle\Entity\Mail $mail
     */
    public function removeMail(\LaNet\LaNetBundle\Entity\Mail $mail)
    {
        $this->mail->removeElement($mail);
    }

    /**
     * Get mail
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set showPhone
     *
     * @param boolean $showPhone
     * @return User
     */
    public function setShowPhone($showPhone)
    {
        $this->showPhone = $showPhone;
    
        return $this;
    }

    /**
     * Get showPhone
     *
     * @return boolean 
     */
    public function getShowPhone()
    {
        return $this->showPhone;
    }

    /**
     * Set showMail
     *
     * @param boolean $showMail
     * @return User
     */
    public function setShowMail($showMail)
    {
        $this->showMail = $showMail;
    
        return $this;
    }

    /**
     * Get showMail
     *
     * @return boolean 
     */
    public function getShowMail()
    {
        return $this->showMail;
    }

    /**
     * Set termsConditions
     *
     * @param boolean $termsConditions
     * @return User
     */
    public function setTermsConditions($termsConditions)
    {
        $this->termsConditions = $termsConditions;
    
        return $this;
    }

    /**
     * Get termsConditions
     *
     * @return boolean 
     */
    public function getTermsConditions()
    {
        return $this->termsConditions;
    }

    /**
     * Set newsNotify
     *
     * @param boolean $newsNotify
     * @return User
     */
    public function setNewsNotify($newsNotify)
    {
        $this->newsNotify = $newsNotify;
    
        return $this;
    }

    /**
     * Get newsNotify
     *
     * @return boolean 
     */
    public function getNewsNotify()
    {
        return $this->newsNotify;
    }
}