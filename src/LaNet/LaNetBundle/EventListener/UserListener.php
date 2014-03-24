<?php

namespace LaNet\LaNetBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use LaNet\LaNetBundle\Entity\Master;
use LaNet\LaNetBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;


class UserListener
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }    
    
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        if ($entity instanceof User)
        {
           $value=$this->container->get('request')->attributes->all();
           if(preg_match('/fos_user_registration_register/',$value['_route']))
           {
               $master=new Master();
               $master->setUser($entity);
               $entityManager->persist($master);
               $entity->addRole('ROLE_MASTER');
           }
           
        }
    }
}
?>
