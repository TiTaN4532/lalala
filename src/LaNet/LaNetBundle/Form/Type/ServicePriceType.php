<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ServicePriceType extends AbstractType
{
  
  private $master;
  
  public function __construct($master){
        $this->master = $master;
    }
    
    
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $master = $this->master;
    $builder -> add('services', 'entity', array(
                              'attr' => array('class' => 'service-list'),
                              'label' => 'Услуга:',
                              'class' => 'LaNet\LaNetBundle\Entity\MasterCategoryService',
//                              'choices' => $this->master->getCategory()->getServices(),
                              'query_builder' => function(\Doctrine\ORM\EntityRepository $er) use ($master) {
                                  if($master->getCategory()) {
                                    return $er->createQueryBuilder('s')
                                                  ->where('s.category = :category')
                                                  ->setParameter('category', $master->getCategory());
                                  } else {
                                    return $er->createQueryBuilder('s')
                                                  ->orderBy('s.category', 'ASC');
                                  }
                                  
                              },
                              'property'     => 'name',
                              'multiple'     => false,
                              'expanded' => false,
                              'empty_value' => 'None'
                            )) 
             ->add('newservice', 'text', array('mapped' => false,
                                               'attr' => array('class' => 'new-service', 'disabled' => 'desabled'),
                                               'label' => 'Новая услуга:'))
             -> add('price', 'integer', array('label' => 'Цена:'));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
            'data_class' => 'LaNet\LaNetBundle\Entity\MasterCategoryServicePrice'
            ));
  }

  public function getName()
  {
    return 'service_price';
  }
}