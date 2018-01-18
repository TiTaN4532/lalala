<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DiscountsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder -> add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'image_path' => 'webPath'))
                ->add('description', 'textarea', array('label' => 'Описание'))
                ->add('startDate', 'text', array( 'required'  => false,  'label' => 'Дата начала:', 'attr' => array('class' => 'datepicker third', 'readonly' => true))) 
                ->add('endDate', 'text', array( 'required'  => false,  'label' => 'Дата окончания:', 'attr' => array('class' => 'datepicker third', 'readonly' => true))) 
                ->add('save', 'submit', array('label' => 'Сохранить'));

            

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => 'LaNet\LaNetBundle\Entity\Discounts'
      ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lanet_discount';
    }
}
