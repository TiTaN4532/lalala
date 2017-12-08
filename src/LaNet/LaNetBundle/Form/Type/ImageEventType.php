<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ImageEventType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder -> add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'image_path' => 'webPath', 'label' => 'Фото:'))
             -> add('description', 'text', array('label' => 'Описание:'))
             -> add('gallery', 'checkbox', array('label' => 'Отображать в галерее на главной', 'required' => false));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
            'data_class' => 'LaNet\LaNetBundle\Entity\Image'
            ));
  }

  public function getName()
  {
    return 'image';
  }
}