<?php

namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RegistrationFormType extends AbstractType
{
    const CONSUMER = 'consumer';
    const SPECIALIST = 'specialist';
    const SALON = 'salon';
    const AGANCY = 'agancy';
    const SHOP = 'shop';
    const SCHOOL_CENTER = 'school_center';

    protected $action;
    
    private $class;

    private $container;
  
    /**
     * @param string $class The User class name
     */

    public function __construct($class, ContainerInterface $container)
    {
        $this->container = $container;
        
        $action = $this->container->get('request')->query->get('type');
        $this->class = $class;
        
        if ($action)
        {
            $this->action = $action;
        }
        
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        if (RegistrationFormType::CONSUMER == $this->action) {
            $this->_buildFormConsumer($builder);
        } elseif (RegistrationFormType::SPECIALIST == $this->action) {
            $this->_buildFormMaster($builder);
        } elseif (RegistrationFormType::SALON == $this->action) {
            $this->_buildFormSalon($builder);
        } elseif (RegistrationFormType::AGANCY == $this->action) {
            $this->_buildFormAgancy($builder);
        } elseif (RegistrationFormType::SHOP == $this->action) {
            $this->_buildFormShop($builder);
        } elseif (RegistrationFormType::SCHOOL_CENTER == $this->action) {
            $this->_buildFormSchoolCenter($builder);
        }
       
    }

    protected function _buildFormMain(FormBuilderInterface $builder)
    {
        $builder
            ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('city',  new CityType())
        ;
    }
    protected function _buildFormConsumer(FormBuilderInterface $builder)
    {
        $this->_buildFormMain($builder);
        $builder->add('userInfo', new ConsumerType(), array('label' => ' '));
    }
    
    protected function _buildFormMaster(FormBuilderInterface $builder)
    {
        $this->_buildFormMain($builder);
        $builder->add('userInfo', new MasterProfileType(), array('label' => ' '));
    }
    
    protected function _buildFormSalon(FormBuilderInterface $builder)
    {
        $this->_buildFormMain($builder);
        $builder->add('userInfo', new SalonType(), array('label' => ' '));
    }
    
    protected function _buildFormAgancy(FormBuilderInterface $builder)
    {
        $this->_buildFormMain($builder);
        $builder->add('userInfo', new AgancyType(), array('label' => ' '));
    }
    
    protected function _buildFormShop(FormBuilderInterface $builder)
    {
        $this->_buildFormMain($builder);
        $builder->add('userInfo', new ShopType(), array('label' => ' '));
    }
    
    protected function _buildFormSchoolCenter(FormBuilderInterface $builder)
    {
        $this->_buildFormMain($builder);
        $builder->add('userInfo', new SchoolCenterType(), array('label' => ' '));
    }

   public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'registration',
        ));
    }

    public function getName()
    {
        return 'la_user_registration';
    }
}
