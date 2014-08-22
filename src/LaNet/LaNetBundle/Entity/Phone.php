<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phone
 *
 * @ORM\Table(name = "phone")
 * @ORM\Entity
 */
class Phone
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
    protected $number;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $operator;
    
    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    protected $showPhone;
     /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="phone")
     */
    private $user;
   

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
     * @return Phone
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
     * Set user
     *
     * @param \LaNet\LaNetBundle\Entity\User $user
     * @return Phone
     */
    public function setUser(\LaNet\LaNetBundle\Entity\User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return \LaNet\LaNetBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return Phone
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set operator
     *
     * @param string $operator
     * @return Phone
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    
        return $this;
    }

    /**
     * Get operator
     *
     * @return string 
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set showPhone
     *
     * @param boolean $showPhone
     * @return Phone
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
}