<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MasterType extends AbstractType
{
    
    protected $action;
   
    /**
     * @param string $class The User class name
     */

    public function __construct($action = 'registration')
    {
        $this->action = $action;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', array('label' => 'Имя:'))
            ->add('lastName', 'text', array('label' => 'Фамилия:'))
            ->add('gender', 'choice', array('label' => 'Пол:', 'choices'   => array('m' => 'Муж', 'f' => 'Жен'),
                                            'required'  => false,
            ))  
            ->add('serviceType', 'choice', array('label' => 'Тип обслуживания:', 
                                                 'choices'   => array('home' => 'Выезд на дом', 'salon' => 'Салон', 'salon-home' => 'Салон/Выезд на дом', 'consult' => 'консультации'),
                                                 'required'  => false,
                                                 'multiple' => true,
                                                 'expanded' => true,
            ))
            ->add('birthday', 'birthday', array('label' => 'Дата рождения:', 'empty_value' => 'Не выбрано', 'format' => 'yyyyMdd','years' => range(1950, date('Y')), 'attr' => array('class' => 'width-auto')))    
            ->add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'label' => "Фото:", 'image_path' => 'webPath'))
            ->add('category', 'entity', array(
                  'attr' => array('class' => 'category-list'),
                  'label' => 'Профиль мастера:',
                  'class' => 'LaNet\LaNetBundle\Entity\MasterCategory',
                  'property'     => 'name',
                  'multiple'     => true,
                  'expanded' => true
                ))  
            ->add('location', new LocationType(), array(
                                                    'by_reference' => false,
                                                    'label' => 'Адрес:'
                                                  ))
            ->add('startWork', 'birthday', array('label' => 'Начало работы:', 'empty_value' => 'Не выбрано', 'format' => 'yyyyMdd','years' => range(1950, date('Y')), 'attr' => array('class' => 'width-auto')))    
            ;
        if($this->action == 'profile')
            $builder->add('competitions', 'text', array('label' => 'Конкурсы, мероприятия:'))
                    ->add('education', 'text', array('label' => 'Образование:'))
                    ->add('usedCosmetics', 'text', array('label' => 'Используемая косметика:'))
                    ->add('hobby', 'text', array('label' => 'Хобби:'))
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
