<?php

namespace LaNet\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'ФИО'))
            ->add('subject', 'text', array('label' => 'Тема 22:'))
            ->add('body', 'textarea', array('label' => 'Сообщение2:'))
            ->add('company', 'text', array('label' => 'Название компании:', 'required' => false))
            ->add('phone', 'text', array('label' => 'Телефон:'))
            ->add('mail', 'email', array('label' => 'Email адрес'))
            ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lanet_contact';
    }
}