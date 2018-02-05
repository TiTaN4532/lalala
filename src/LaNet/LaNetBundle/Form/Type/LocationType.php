<?php
namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class LocationType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            //->add('country', 'text', array('required' => false, 'attr' => array('class' => 'hidden')))
            ->add('address', 'text', array('required' => false, 'attr' => array('')))
            ->add('locality', 'text',  array('required' => false, 'attr' => array('class' => 'hidden')))
            /*->add('administrative_area', 'text',  array('required' => false, 'attr' => array('class' => 'hidden')))
            ->add('sublocality', 'text',   array('required' => false, 'attr' => array('class' => 'hidden')))
            ->add('route', 'text',   array('required' => false, 'attr' => array('class' => 'hidden')))
            ->add('streetNumber', 'text',   array('required' => false, 'attr' => array('class' => 'hidden')))*/
            ->add('lang', 'text',   array('required' => false, 'attr' => array('class' => 'hidden'))) 
            ->add('lat', 'text',   array('required' => false, 'attr' => array('class' => 'hidden'))) 
            ;
    }
    
   

    public function getName()
    {
        return 'location';
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LaNet\LaNetBundle\Entity\Location'
        ));
    }
}
?>
