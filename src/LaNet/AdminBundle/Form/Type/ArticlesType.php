<?php

namespace LaNet\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ArticlesType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder -> add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'image_path' => 'webPath'))
             -> add('title', 'text', array('label' => 'Заголовок:'))
             -> add('description', 'textarea', array('label' => 'Краткое описание:'))
             -> add('video', 'textarea', array('label' => 'Вставка видео:', 'required' => false))
             //-> add('date', 'text', array( 'required'  => true,  'label' => 'Дата:', 'attr' => array('class' => 'datepicker')))   
             ->add('date','date',array('widget' => 'single_text', 'label' => 'Дата:', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'datepicker half')))
            -> add('portfolio', 'collection', array(
                                'by_reference' => false,
                                'type'         => new \LaNet\LaNetBundle\Form\Type\ImageType(),
                                'allow_add'    => true,
                                'allow_delete'    => true,
                  ))
            -> add('post', 'textarea', array('label' => 'Текст:', 'required' => false, 'attr' => array('class' => "TextEditor")))
             -> add('save_draft', 'submit', array('label' => 'Сохранить как черновик'))
             -> add('add_post', 'submit', array('label' => 'Сохранить'));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => 'LaNet\LaNetBundle\Entity\Articles'
      ));
  }


  public function getName()
  {
    return 'articles';
  }
}