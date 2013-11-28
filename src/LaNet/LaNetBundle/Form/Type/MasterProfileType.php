<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MasterProfileType extends AbstractType
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
            ->add('adress', 'text', array('label' => 'Адресс:'))
            ->add('phone', 'text', array('label' => 'Номер телефона:'))
            ->add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'label' => "Image:", 'image_path' => 'webPath'))
//            ->add('specialties', 'entity', array(
//                  'by_reference' => false,
//                  'class' => 'SproutBack\SproutBackBundle\Entity\Specialty',
//                  'property'     => 'name',
//                  'multiple'     => true,
//                  'expanded' => true,
//                  'attr'      => array('class' => 'speciality-list')
//                )) 
            ->add('save', 'submit', array('label' => 'Сохранить'))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LaNet\LaNetBundle\Entity\Master'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lanet_prifile';
    }
}
