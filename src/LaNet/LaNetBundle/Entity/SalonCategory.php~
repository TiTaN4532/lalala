<?php

namespace LaNet\LaNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="salon_category")
 */
class SalonCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
     * @ORM\OneToMany(targetEntity="Salon", mappedBy="category")
     */
    private $salons;
       
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $name;
    
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->salons = new \Doctrine\Common\Collections\ArrayCollection();
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
     *
     * @param \LaNet\LaNetBundle\Entity\Salon $salon
     * @return SalonCategory
     */
    public function addSalon(\LaNet\LaNetBundle\Entity\Salon $salon)
    {
        $this->salons[] = $salon;
    
        return $this;
    }

    /**
     *
     * @param \LaNet\LaNetBundle\Entity\Salon $salon
     */
    public function removeSalon(\LaNet\LaNetBundle\Entity\Salon $salon)
    {
        $this->salons->removeElement($salon);
    }

    /**
     * Get salons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSalons()
    {
        return $this->salons;
    }
}