<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="school_center_category")
 */
class SchoolCenterCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
     * @ORM\OneToMany(targetEntity="SchoolCenter", mappedBy="category")
     */
    private $schoolCenter;
       
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
     * Add schoolCenter
     *
     * @param \LaNet\LaNetBundle\Entity\SchoolCenter $schoolCenter
     * @return SchoolCenterCategory
     */
    public function addSchoolCenter(\LaNet\LaNetBundle\Entity\SchoolCenter $schoolCenter)
    {
        $this->schoolCenter[] = $schoolCenter;
    
        return $this;
    }

    /**
     * Remove schoolCenter
     *
     * @param \LaNet\LaNetBundle\Entity\SchoolCenter $schoolCenter
     */
    public function removeSchoolCenter(\LaNet\LaNetBundle\Entity\SchoolCenter $schoolCenter)
    {
        $this->schoolCenter->removeElement($schoolCenter);
    }

    /**
     * Get schoolCenter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchoolCenter()
    {
        return $this->schoolCenter;
    }
}