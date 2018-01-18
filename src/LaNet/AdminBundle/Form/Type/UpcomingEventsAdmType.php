<?php

namespace LaNet\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UpcomingEventsAdmType extends AbstractType
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
                ->add('post', 'textarea', array('label' => 'Текст', 'required' => false, 'attr' => array('class' => "TextEditor")))
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
          'data_class' => 'LaNet\LaNetBundle\Entity\UpcomingEvents'
      ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lanet_upcoming_events';
    }
}
