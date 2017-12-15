<?php

namespace  LaNet\LaNetBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaNet\LaNetBundle\Entity as LaEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


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
     * @ORM\OneToOne(targetEntity="Brand", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $brandInfo;
    
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
     * @ORM\OneToOne(targetEntity="School", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $schoolInfo;


    /**
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="user", cascade={"persist"}, orphanRemoval=true)
     */
    protected $phone;
    
    /**
     * @ORM\OneToMany(targetEntity="Mail", mappedBy="user", cascade={"persist"}, orphanRemoval=true)
     */
    protected $mail;
    
    
    /**
     * @ORM\Column(type="string", length=10, nullable = true)
     */
    protected $votes;
    
    /**
     * @ORM\Column(type="string", length=5, nullable = true)
     */
    protected $rating;
    
  
     /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;
    
    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    protected $termsConditions;
    
    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    protected $premium;
    
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
        } elseif ($userInfo instanceof LaEntity\Brand) {
            $this->brandInfo = $userInfo;
        } elseif ($userInfo instanceof LaEntity\School) {
            $this->schoolInfo = $userInfo;
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
        } elseif ($this->hasRole('ROLE_BRAND')) {
            return $this->brandInfo;
        } elseif ($this->hasRole('ROLE_SCHOOL_CENTER')) {
            return $this->schoolInfo;
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
    public function setSchoolInfo(\LaNet\LaNetBundle\Entity\School $schoolInfo = null)
    {
        $this->schoolInfo = $schoolInfo;
    
        return $this;
    }

    /**
     * Get salonInfo
     *
     * @return \LaNet\LaNetBundle\Entity\Salon 
     */
    public function getSchoolInfo()
    {
        return $this->schoolInfo;
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
     * Set agancyInfo
     *
     * @param \LaNet\LaNetBundle\Entity\Agancy $agancyInfo
     * @return User
     */
    public function setBrandInfo(\LaNet\LaNetBundle\Entity\Brand $brandInfo = null)
    {
        $this->brandInfo = $brandInfo;
    
        return $this;
    }

    /**
     * Get agancyInfo
     *
     * @return \LaNet\LaNetBundle\Entity\Agancy 
     */
    public function getBrandInfo()
    {
        return $this->brandInfo;
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
     * Get premium
     *
     * @return boolean 
     */
    
    public function getPremium()
    {
        return $this->premium;
    }
    /**
     * Set premium
     *
     * @param boolean $premium
     * @return User
     */
    public function setPremium($premium)
    {
        $this->premium = $premium;
    
        return $this;
    }
    /**
     * Get votes
     *
     * @return string 
     */
    
    public function getVotes()
    {
        return $this->votes;
    }
    /**
     * Set votes
     *
     * @param string $votes
     * @return User
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;
    
        return $this;
    }
    /**
     * Get rating
     *
     * @return string 
     */
    
    public function getRating()
    {
        return $this->rating;
    }
    /**
     * Set rating
     *
     * @param string $rating
     * @return User
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    
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
    
    public function hasPhones() {
        $result = false;
        foreach($this->phone as $value)
            if($value->getShowPhone())
                $result = true;
        return $result;
    }
    
    public function hasMails() {
        $result = false;
        foreach($this->mail as $value)
            if($value->getShowMail())
                $result = true;
        return $result;
    }
}