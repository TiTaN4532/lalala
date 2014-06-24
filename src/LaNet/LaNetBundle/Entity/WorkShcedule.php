<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkShcedule
 *
 * @ORM\Table(name = "shcedule")
 * @ORM\Entity
 */
class WorkShcedule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $nameRus;
    
    /**
     * @ORM\OneToMany(targetEntity="MasterWorkShcedule", mappedBy="shcedule")
     */
    protected $schedule;
    

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
     * @return WorkShcedule
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
     * Set nameRus
     *
     * @param string $nameRus
     * @return WorkShcedule
     */
    public function setNameRus($nameRus)
    {
        $this->nameRus = $nameRus;
    
        return $this;
    }

    /**
     * Get nameRus
     *
     * @return string 
     */
    public function getNameRus()
    {
        return $this->nameRus;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->schedule = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add schedule
     *
     * @param \LaNet\LaNetBundle\Entity\MasterWorkShcedule $schedule
     * @return WorkShcedule
     */
    public function addSchedule(\LaNet\LaNetBundle\Entity\MasterWorkShcedule $schedule)
    {
        $this->schedule[] = $schedule;
    
        return $this;
    }

    /**
     * Remove schedule
     *
     * @param \LaNet\LaNetBundle\Entity\MasterWorkShcedule $schedule
     */
    public function removeSchedule(\LaNet\LaNetBundle\Entity\MasterWorkShcedule $schedule)
    {
        $this->schedule->removeElement($schedule);
    }

    /**
     * Get schedule
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchedule()
    {
        return $this->schedule;
    }
}