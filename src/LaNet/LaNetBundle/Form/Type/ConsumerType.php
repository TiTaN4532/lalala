<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('phone', 'text', array('label' => 'Номер телефона:'))
            ->add('gender', 'choice', array('label' => 'Пол:', 'choices'   => array('m' => 'Муж', 'f' => 'Жен'),
                                            'required'  => false,
            ))  
            ->add('birthday', 'birthday', array('label' => 'Дата рождения:', 'empty_value' => 'Не выбрано', 'format' => 'yyyyMdd','years' => range(1950, date('Y')), 'attr' => array('class' => 'width-auto')))    
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
