<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use LaNet\LaNetBundle\Form\Type\LocationType;

class ConsumerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', array('label' => 'Имя:'))
            ->add('lastName', 'text', array('label' => 'Фамилия:'))
            ->add('gender', 'choice', array('label' => 'Пол:', 'choices'   => array('m' => 'Муж', 'f' => 'Жен'),
                                            'required'  => false,
            ))  
            ->add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'label' => "Фото:", 'image_path' => 'webPath'))
                
            ->add('birthday', 'date', array(   'label' => 'Дата рождения:', 
                                                'input'  => 'timestamp',
                                                'widget' => 'single_text')) 
            ->add('location', new LocationType(true), array(
                                                    'by_reference' => false,
                                                    'label' => 'Адрес:'
                                                  ))  
            ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LaNet\LaNetBundle\Entity\Consumer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lanet_consumer';
    }
}
