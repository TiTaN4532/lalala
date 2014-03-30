<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="agancy_category")
 */
class AgancyCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
     * @ORM\OneToMany(targetEntity="Agancy", mappedBy="category")
     */
    private $agancy;
       
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $name;
    
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->agancy = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity(array(
            'fields'    => array('name'),
            'message'   => 'Такая категория уже существует.',
        )));
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
     * Add agancy
     *
     * @param \LaNet\LaNetBundle\Entity\Agancy $agancy
     * @return AgancyCategory
     */
    public function addAgancy(\LaNet\LaNetBundle\Entity\Agancy $agancy)
    {
        $this->agancy[] = $agancy;
    
        return $this;
    }

    /**
     * Remove agancy
     *
     * @param \LaNet\LaNetBundle\Entity\Agancy $agancy
     */
    public function removeAgancy(\LaNet\LaNetBundle\Entity\Agancy $agancy)
    {
        $this->agancy->removeElement($agancy);
    }

    /**
     * Get agancy
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAgancy()
    {
        return $this->agancy;
    }
}