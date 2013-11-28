<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MasterWorkType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', array(
                  'attr' => array('class' => 'category-list'),
                  'label' => 'Профиль мастера:',
                  'class' => 'LaNet\LaNetBundle\Entity\MasterCategory',
                  'property'     => 'name',
                  'multiple'     => false,
                  'expanded' => false,
                  'empty_value' => 'None'
                ))   
            ->add('newcategory', 'text', array('mapped' => false,
                                               'attr' => array('class' => 'new-category'),
                                               'label' => 'Новая категория:'))
            ->add('saloon', 'text', array('label' => 'Салон:'))
            ->add('experience', 'integer', array('label' => 'Опыт работы:'))
            ->add('usedcosmetics', 'text', array('label' => 'Использует косметику:'))
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
        return 'lanet_prifile_work';
    }
}
