<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AgancyType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Название:'))
            ->add('description', 'textarea', array('required'  => false, 'label' => 'Описание:'))
            ->add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'label' => "Фото:", 'image_path' => 'webPath'))
             
            ->add('category', 'entity', array(
                  'attr' => array('class' => 'category-list'),
                  'label' => 'Товары для мастеров:',
                  'class' => 'LaNet\LaNetBundle\Entity\MasterCategory',
                  'property'     => 'name',
                  'multiple'     => true,
                  'expanded' => true,
                ))  
            ->add('location', new LocationType(), array(
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
            'data_class' => 'LaNet\LaNetBundle\Entity\Agancy'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lanet_agancy';
    }
}
