<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdvertsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                -> add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'image_path' => 'webPath'))
            ->add('title', 'text', array('label' => 'Заголовок'))
            ->add('post', 'textarea', array('label' => 'Текст объявления'))
            ->add('phone', 'text', array('label' => 'Телефон:', 'required' => false))
            ->add('name', 'text', array('label' => 'Имя:'))
            ->add('mail', 'email', array('label' => 'Email адрес'))
            ->add('add_post', 'submit', array('label' => 'Сохранить'))
            ->add('public', 'submit', array('label' => 'Опубликовать'))
            ->add('draft', 'submit', array('label' => 'Скрыть'));
            ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => 'LaNet\LaNetBundle\Entity\Adverts'
      ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lanet_adverts';
    }
}
