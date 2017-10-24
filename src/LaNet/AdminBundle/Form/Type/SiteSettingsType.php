<?php

namespace LaNet\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class SiteSettingsType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder -> add('name', 'text', array('label' => 'Название:', 'required' => false))
             -> add('description', 'textarea', array('label' => 'Возможности портала:',  'required' => false, 'attr' => array('class' => "TextEditor")))
             -> add('save', 'submit', array('label' => 'Сохранить'));
  }        

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  
 {
      $resolver->setDefaults(array(
          'data_class' => 'LaNet\LaNetBundle\Entity\SiteSettings'
      ));
  }


  public function getName()
  {
    return 'siteSettings';
  }
}