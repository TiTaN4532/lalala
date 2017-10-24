<?php

namespace LaNet\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class BrandType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder -> add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'image_path' => 'webPath'))
             -> add('name', 'text', array('label' => 'Название:'))
             -> add('country', 'text', array('label' => 'Страна производитель:', 'required' => false))
             -> add('link', 'text', array('label' => 'Сайт:', 'required' => false))
             -> add('description', 'textarea', array('label' => 'Описание:'))
             ->add('phone', 'text', array('label' => 'Телефон:', 'required' => false))
             ->add('mail', 'email', array('label' => 'Email адрес', 'required' => false)) 
             ->add('category', 'collection', array( 'type'         => new BrandCategoryType(),
                                                    'allow_add'    => true,
                                                    'allow_delete'    => true,
                                                    'by_reference' => false,
                    ))
            ->add('masterCategory', 'entity', array(
                  'attr' => array('class' => 'category-list'),
                  'label' => 'Товары для мастеров:',
                  'class' => 'LaNet\LaNetBundle\Entity\MasterCategory',
                  'property'     => 'name',
                  'multiple'     => true,
                  'expanded' => true
                )) 
             -> add('save', 'submit', array('label' => 'Сохранить'))
             -> add('add_brand', 'submit', array('label' => 'Опубликовать'))
             -> add('is_draft', 'submit', array('label' => 'Скрыть'));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => 'LaNet\LaNetBundle\Entity\Brand'
      ));
  }


  public function getName()
  {
    return 'brand';
  }
}