<?php
namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class LocationType extends AbstractType
{
    
    private $restriction;
    /**
     * @param string $class The User class name
     */

    public function __construct($restriction = false)
    {
        $this->restriction = $restriction;
  
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->_buildRestrictForm($builder);
        if(!$this->restriction) {
            $this->_buildWholeForm($builder);
        } 
    }
    
    public function _buildWholeForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('district', 'text', array('label' => 'Район:'))
            ->add('station', 'text', array('label' => 'Станция метро:'))
            ->add('street', 'text', array('label' => 'Улица:'))
            ->add('building', 'text',  array('label' => 'Дом:'))  
            ;
    }
    
    public function _buildRestrictForm(FormBuilderInterface $builder)
    {
         $builder
            ->add('city', 'entity', array(
                  'attr' => array('class' => 'city-list'),
                  'label' => 'Город:',
                  'class' => 'LaNet\LaNetBundle\Entity\City',
                  'property'     => 'name',
                  'multiple'     => false,
                  'expanded' => false,
                  'empty_value' => 'Выберите город'
                ))
            ->add('region', 'entity', array(
                  'attr' => array('class' => 'region-list'),
                  'label' => 'Область:',
                  'class' => 'LaNet\LaNetBundle\Entity\Region',
                  'property'     => 'name',
                  'multiple'     => false,
                  'expanded' => false,
                  'empty_value' => 'Выберите область'
                ))  
            ->add('country', 'entity', array(
                  'attr' => array('class' => 'country-list'),
                  'label' => 'Страна:',
                  'class' => 'LaNet\LaNetBundle\Entity\Country',
                  'property'     => 'name',
                  'query_builder' => function (EntityRepository $repository)
                     {
                         return $repository->createQueryBuilder('s')
                                ->where('s.id = 9908');
                     },
                  'multiple'     => false,
                  'expanded' => false,
                  'empty_value' => 'Выберите страну'
                ))  
            ;
    }

    public function getName()
    {
        return 'location';
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LaNet\LaNetBundle\Entity\Location'
        ));
    }
}
?>
