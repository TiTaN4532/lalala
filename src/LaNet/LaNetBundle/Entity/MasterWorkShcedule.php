<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MasterWorkSchedule
 *
 * @ORM\Table(name = "masters_shcedule")
 * @ORM\Entity
 */
class MasterWorkShcedule
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
     * @ORM\ManyToOne(targetEntity="WorkShcedule", inversedBy="masters", cascade={"persist"})
     */
    private $shcedule;
    
    /**
     * @ORM\ManyToOne(targetEntity="Master", inversedBy="shcedule")
     */
    private $master;

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
     * @return MasterWorkShcedule
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
     * @return MasterWorkShcedule
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
     * @return MasterWorkShcedule
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
     * Set master
     *
     * @param \LaNet\LaNetBundle\Entity\Master $master
     * @return MasterWorkShcedule
     */
    public function setMaster(\LaNet\LaNetBundle\Entity\Master $master = null)
    {
        $this->master = $master;
    
        return $this;
    }

    /**
     * Get master
     *
     * @return \LaNet\LaNetBundle\Entity\Master 
     */
    public function getMaster()
    {
        return $this->master;
    }
}