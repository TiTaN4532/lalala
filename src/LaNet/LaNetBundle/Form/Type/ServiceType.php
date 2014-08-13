<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ServiceType extends AbstractType
{
    
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder ->add('name', 'text', array('label' => 'Услуга:', 'attr' => array('class' => 'half')))
             ->add('startPrice', 'text', array('label' => 'Цена от:', 'attr' => array('class' => 'half')))
             ->add('endPrice', 'text', array('label' => 'До:', 'attr' => array('class' => 'half')));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
            'data_class' => 'LaNet\LaNetBundle\Entity\Service'
            ));
  }

  public function getName()
  {
    return 'service_price';
  }
}