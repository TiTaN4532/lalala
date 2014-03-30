<?php

namespace LaNet\LaNetBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AutoRoleAssignmentListener implements EventSubscriberInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }  
    
    public static function getSubscribedEvents()
    {
      return [ FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess', FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialise' ];
    }

    public function onRegistrationSuccess( FormEvent $event )
    {
      $roles = array('specialist' => 'ROLE_SPECIALIST',
                     'consumer' => 'ROLE_CONSUMER',
                     'salon' => 'ROLE_SALON', 
                     'agancy' => 'ROLE_AGANCY',
                     'shop' => 'ROLE_SHOP',
                     'school_center' => "ROLE_SCHOOL_CENTER");
      $event->getForm()->getData()->addRole($roles[$event->getRequest()->query->get('type')]);

      // what do
    }
    
    public function onRegistrationInitialise( UserEvent $event )
    {
           // what do
    }
}
?>
