<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use LaNet\LaNetBundle\Form\Type\LocationType;

class ConsumerProfileType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('userInfo', new ConsumerType(), array('label' => ' '))
                ->add('showMail', 'checkbox', array('label' => 'Отображать адрес электронной почты на сайте', 'required' => false))
                ->add('showPhone', 'checkbox', array('label' => 'Отображать номер телефона на сайте', 'required' => false))
                ->add('newsNotify', 'checkbox', array('label' => 'Подписаться на новости сайта', 'required' => false))
                ->add('save', 'submit', array('label' => 'Сохранить'))
                ->add('phone', 'collection', array( 'type'         => new PhoneType(),
                                                    'allow_add'    => true,
                                                    'allow_delete'    => true,
                                                    'by_reference' => false,
                    ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LaNet\LaNetBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lanet_consumer_profile';
    }
}
