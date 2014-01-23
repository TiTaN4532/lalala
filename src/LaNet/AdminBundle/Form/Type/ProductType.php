<?php

namespace LaNet\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ProductType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder -> add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'image_path' => 'webPath'))
             -> add('name', 'text', array('label' => 'Название:'))
             -> add('description', 'textarea', array('label' => 'Описание:'))
             -> add('category', 'entity', array(
                        'class' => 'LaNetLaNetBundle:ProductCategory',
                        'property' => 'name',
                    ))
             -> add('brand', 'entity', array(
                        'class' => 'LaNetLaNetBundle:Brand',
                        'property' => 'name',
                    ))
             -> add('save', 'submit', array('label' => 'Сохранить'));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => 'LaNet\LaNetBundle\Entity\Product'
      ));
  }


  public function getName()
  {
    return 'product';
  }
}