<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalonWorkSchedule
 *
 * @ORM\Table(name = "salons_shcedule")
 * @ORM\Entity
 */
class SalonWorkShcedule
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $startTime;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $endTime;
    
     /**
     * @ORM\ManyToOne(targetEntity="WorkShcedule", inversedBy="salons", cascade={"persist"})
     */
    private $shcedule;
    
    /**
     * @ORM\ManyToOne(targetEntity="Salon", inversedBy="shcedule")
     */
    private $salon;

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
     * Set startTime
     *
     * @param string $startTime
     * @return SalonWorkShcedule
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return string 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param string $endTime
     * @return SalonWorkShcedule
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    
        return $this;
    }

    /**
     * Get endTime
     *
     * @return string 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set shcedule
     *
     * @param \LaNet\LaNetBundle\Entity\WorkShcedule $shcedule
     * @return SalonWorkShcedule
     */
    public function setShcedule(\LaNet\LaNetBundle\Entity\WorkShcedule $shcedule = null)
    {
        $this->shcedule = $shcedule;
    
        return $this;
    }

    /**
     * Get shcedule
     *
     * @return \LaNet\LaNetBundle\Entity\WorkShcedule 
     */
    public function getShcedule()
    {
        return $this->shcedule;
    }

    /**
     * Set salon
     *
     * @param \LaNet\LaNetBundle\Entity\Salon $salon
     * @return SalonWorkShcedule
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
}