<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SchoolType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Название:'))
            ->add('description', 'textarea', array('label' => 'Описание:', 'required' => false))    
            ->add('link', 'text', array('required'  => false, 'label' => 'Сайт:'))
            ->add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'label' => "Фото:", 'image_path' => 'webPath'))
             
            ->add('brandsCategory', 'entity', array(
                  'attr' => array('class' => 'category-list'),
                  'label' => 'Специализация мастеров:',
                  'class' => 'LaNet\LaNetBundle\Entity\BrandsCategory',
                  'property'     => 'name',
                  'multiple'     => true,
                  'expanded' => true,
                ))  
            ->add('location', new LocationType(), array(
                                                    'by_reference' => false,
                                                    'label' => 'Адрес:'
                                                  ));

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LaNet\LaNetBundle\Entity\School'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lanet_school';
    }
}
