<?php

namespace LaNet\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class MasterType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder ->add('firstName', 'text', array('label' => 'Имя:'))
            ->add('lastName', 'text', array('label' => 'Фамилия:'))
            ->add('adress', 'text', array('label' => 'Адресс:'))
            ->add('phone', 'text', array('label' => 'Номер телефона:'))
            ->add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'label' => "Image:", 'image_path' => 'webPath'))
            ->add('category', 'entity', array(
                  'attr' => array('class' => 'category-list'),
                  'label' => 'Профиль мастера:',
                  'class' => 'LaNet\LaNetBundle\Entity\MasterCategory',
                  'property'     => 'name',
                  'multiple'     => false,
                  'expanded' => false,
                  'empty_value' => 'None'
                ))   
//            ->add('newcategory', 'text', array('mapped' => false,
//                                               'attr' => array('class' => 'new-category'),
//                                               'label' => 'Новая категория:'))
            ->add('saloon', 'text', array('label' => 'Салон:'))
            ->add('experience', 'integer', array('label' => 'Опыт работы:'))
            ->add('usedcosmetics', 'text', array('label' => 'Использует косметику:'))
            ->add('save', 'submit', array('label' => 'Сохранить'));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => 'LaNet\LaNetBundle\Entity\Master'
      ));
  }


  public function getName()
  {
    return 'master';
  }
}