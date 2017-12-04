<?php

namespace LaNet\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductCategoryType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array('label' => 'Название', 'attr' => array('class' => 'half')))
                ->add('descriptionItem', 'collection', array(
                    'by_reference' => false,
                    'type' => new \LaNet\AdminBundle\Form\Type\ProductCategoryDescrItemType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                ))
                /*->add('brand', 'entity', array(
                    'label' => 'Бренд',
                    'class' => 'LaNetLaNetBundle:Brand',
                    'property' => 'name',
                    'empty_value' => 'Выберите брэнд',
                    'empty_data' => null
                ))*/
                /*->add('masterCategory', 'entity', array(
                    'label' => 'Специализация:',
                    'class' => 'LaNetLaNetBundle:MasterCategory',
                    'property' => 'name',
                    'empty_value' => 'Выберите специализацию',
                    'empty_data' => null
                ))*/
                ->add('brandCategory', 'entity', array(
                    'label' => 'Специализация:',
                    'class' => 'LaNetLaNetBundle:BrandsCategory',
                    'property' => 'name',
                    'empty_value' => 'Выберите категорию бренда',
                    'empty_data' => null
                ))
                ->add('children', 'collection', array(
                    'by_reference' => false,
                    'type' => new ProductCategoryType(),
                    'allow_add' => true,
                    'prototype' => false,
                    'allow_delete' => true,
                ))
                ->add('save', 'submit', array('label' => 'Сохранить'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'LaNet\LaNetBundle\Entity\ProductCategory'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'product_category';
    }

}
