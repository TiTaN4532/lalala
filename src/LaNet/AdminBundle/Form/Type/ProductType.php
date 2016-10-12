<?php

namespace LaNet\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class ProductType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder -> add('file', new \LaNet\LaNetBundle\Form\Type\ImageUpload(), array('required' => false, 'image_path' => 'webPath'))
             -> add('name', 'text', array('label' => 'Название:'))
             -> add('description', 'textarea', array('required' => false,'label' => 'Описание:'))
            // -> add('contraindications', 'textarea', array('required' => false,'label' => 'Противопоказания:'))
            // -> add('application', 'textarea', array('required' => false,'label' => 'Применение:'))
            /*-> add('brand', 'entity', array(
                        'label' => 'Брэнд',
                        'class' => 'LaNetLaNetBundle:Brand',
                        'property' => 'name',
                        'empty_value' => 'Выберите брэнд',
                        'empty_data'  => null
                    ))*/
             /*-> add('masterCategory', 'entity', array(
                        'label' => 'Специализация:',
                        'class' => 'LaNetLaNetBundle:MasterCategory',
                        'property' => 'name',
                        'empty_value' => 'Выберите специализацию',
                        'empty_data'  => null
                    ))*/
             -> add('save', 'submit', array('label' => 'Сохранить'));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => 'LaNet\LaNetBundle\Entity\Product'
      ));
  }


  public function getName()
  {
    return 'product';
  }
}