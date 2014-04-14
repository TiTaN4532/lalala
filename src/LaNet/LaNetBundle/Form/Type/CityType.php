<?php
namespace LaNet\LaNetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Event\DataEvent;

use LaNet\LaNetBundle\Entity\Country;
use LaNet\LaNetBundle\Entity\Region;
use LaNet\LaNetBundle\Entity\City;


class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');

        $factory = $builder->getFormFactory();

        $refreshRegions = function ($form, $country) use ($factory)
        {
            $form->add($factory->createNamed('entity','region', null, array(
                'class'         => 'LaNet\LaNetBundle\Entity\Region',
                'property'      => 'name',
                'empty_value'   => '-- Select a region --',
                'query_builder' => function (EntityRepository $repository) use ($country) 
                                {
                                    $qb = $repository->createQueryBuilder('region')
                                                    ->innerJoin('region.country', 'country');

                                    if($country instanceof Country){
                                        $qb->where('region.country = :country')
                                        ->setParameter('country', $country);
                                    }elseif(is_numeric($country)){
                                        $qb->where('country.id = :country')
                                        ->setParameter('country', $country);
                                    }else{
                                        $qb->where('country.name = :country')
                                        ->setParameter('country', null);
                                    }
                                    return $qb;
                                }
                )));
        };

        $setCountry = function ($form, $country) use ($factory)
        {
            $form->add($factory->createNamed('entity', 'country', null, array(
                    'class'         => 'LaNetBundle:Country', 
                    'property'      => 'name', 
                    'property_path' => false,
                    'empty_value'   => '-- Select a country --',
                    'data'          => $country,
                )));
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvents $event) use ($refreshRegions, $setCountry)
        {
            $form = $event->getForm();
            $data = $event->getData();

            if($data == null)
                return;

            if($data instanceof City){
                $country = ($data->getId()) ? $data->getRegion()->getCountry() : null ;
                $refreshRegions($form, $country);
                $setCountry($form, $country);
            }
        });

        $builder->addEventListener(FormEvents::PRE_BIND, function (FormEvent $event) use ($refreshRegions)
        {
            $form = $event->getForm();
            $data = $event->getData();

            if(array_key_exists('country', $data)) {
                $refreshStates($form, $data['country']);
            }
        });
    }

    public function getName()
    {
        return 'city';
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'LaNet\LaNetBundle\Entity\City');
    }
}
?>
