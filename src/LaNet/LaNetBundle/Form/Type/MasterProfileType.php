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
            ->add('phone', 'text', array('label' => 'Номер телефона:'))
            ->add('gender', 'choice', array('label' => 'Пол:', 'choices'   => array('m' => 'Муж', 'f' => 'Жен'),
                                            'required'  => false,
            ))  
            ->add('serviceType', 'choice', array('label' => 'Тип обслуживания:', 
                                                 'choices'   => array('1' => 'Выезд на дом', '2' => 'Салон', '3' => 'Салон/Выезд на дом', '4' => 'консультации'),
                                                 'required'  => false,
            ))
            ->add('birthday', 'birthday', array('label' => 'Дата рождения:', 'empty_value' => 'Не выбрано', 'format' => 'yyyyMdd','years' => range(1950, date('Y')), 'attr' => array('class' => 'width-auto')))    
            ->add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'label' => "Фото:", 'image_path' => 'webPath'))
            ->add('category', 'entity', array(
                  'attr' => array('class' => 'category-list'),
                  'label' => 'Профиль мастера:',
                  'class' => 'LaNet\LaNetBundle\Entity\MasterCategory',
                  'property'     => 'name',
                  'multiple'     => false,
                  'expanded' => false,
                  'empty_value' => 'None'
                ))  
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
