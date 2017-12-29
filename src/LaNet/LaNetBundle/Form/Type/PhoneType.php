<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PhoneType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', 'text', array('attr' => array('style' => 'width:auto;', 'maxlength' => 13), 'required' => false, 'label' => ' '))
            ->add('operator', 'text', array('attr' => array('style' => 'width:40px;', 'maxlength' => 3), 'required' => false, 'label' => ' '))
            ->add('showPhone', 'checkbox', array('label' => 'Отображать номер телефона на сайте', 'required' => false))
            ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LaNet\LaNetBundle\Entity\Phone'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lanet_phone';
    }
}
