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
            ->add('link', 'text', array('label' => 'Сайт:'))
            ->add('gender', 'choice', array('label' => 'Пол:', 'choices'   => array('m' => 'Муж', 'f' => 'Жен'),
                                            'required'  => true,
            ))  
            ->add('serviceType', 'choice', array('label' => 'Тип обслуживания:', 
                                                 'choices'   => array('home' => 'На дому', 'salon' => 'В салоне', 'salon-home' => 'Выезд на дом к клиенту'),
                                                 'required'  => false,
                                                 'multiple' => true,
                                                 'expanded' => true,
            ))
            ->add('birthday', 'date', array(   'label' => 'Дата рождения:', 
                                                'input'  => 'timestamp',
                                                'widget' => 'single_text'))       
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
            ->add('startWork', 'date', array(   'label' => 'Начало работы:', 
                                                'input'  => 'timestamp',
                                                'widget' => 'single_text'))    
            ;
        if($this->action == 'profile')
            $builder->add('competitions', 'text', array('label' => 'Конкурсы, мероприятия:', 'required' => false))
                    ->add('education', 'text', array('label' => 'Образование:', 'required' => false))
                    ->add('usedCosmetics', 'text', array('label' => 'Используемая косметика:', 'required' => false))
                    ->add('hobby', 'text', array('label' => 'Хобби:', 'required' => false))
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
