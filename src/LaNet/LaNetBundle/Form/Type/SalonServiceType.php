<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SalonServiceType extends AbstractType
{
    
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('services', 'collection', array(
                              'label' => 'Список услуг:',
                             'by_reference' => false,
                             'type'         => new ServiceType(),
                             'allow_add'    => true,
                             'allow_delete'    => true,
                  ))
            ->add('save', 'submit', array('label' => 'Сохранить'))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LaNet\LaNetBundle\Entity\Salon'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lanet_salon_profile_service_price';
    }
}
