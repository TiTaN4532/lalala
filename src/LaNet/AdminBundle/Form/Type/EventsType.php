<?php

namespace LaNet\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class EventsType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder -> add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'image_path' => 'webPath'))
             -> add('title', 'text', array('label' => 'Заголовок:'))
             -> add('description', 'textarea', array('label' => 'Краткое описание:', 'required' => false, 'attr' => array('class' => "TextEditor")))
             -> add('post', 'textarea', array('label' => 'Текст:', 'required' => false, 'attr' => array('class' => "TextEditor")))
             -> add('save_draft', 'submit', array('label' => 'Сохранить как черновик'))
             -> add('add_post', 'submit', array('label' => 'Сохранить'));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => 'LaNet\LaNetBundle\Entity\Events'
      ));
  }


  public function getName()
  {
    return 'events';
  }
}