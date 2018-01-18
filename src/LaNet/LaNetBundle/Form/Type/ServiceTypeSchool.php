<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ServiceTypeSchool extends AbstractType
{
    
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder ->add('name', 'text', array('required' => true, 'label' => 'Услуга:', 'attr' => array('class' => 'half')))
             ->add('startPrice', 'text', array('required' => false,'label' => 'цена от:', 'attr' => array('class' => 'half')))
             ->add('endPrice', 'text', array('required' => false,'label' => 'до:', 'attr' => array('class' => 'half')))
             ->add('description', 'textarea', array('label' => 'Описание:', 'required' => false))
             ->add('length', 'text', array('required' => false,'label' => 'Продолжительность:'));
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