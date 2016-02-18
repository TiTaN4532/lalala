<?php

namespace LaNet\LaNetBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RegistrationNotification implements EventSubscriberInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }  
    
    public static function getSubscribedEvents()
    {
      return array(FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess');
    }

    public function onRegistrationSuccess( FormEvent $event )
    {
    
   
     $form = $event->getForm();
     $email = $form['email']->getData();
       
          
             $message = \Swift_Message::newInstance()
                    ->setSubject('Thanks')
                    ->setFrom('info@lalook.net')
                    ->setTo($email)
                    ->setBody('message')
                   ;
              $this->container->get('mailer')->send($message);
 
    //print_r ($data); 
   // exit;
    }
    
    public function onRegistrationInitialise( UserEvent $event )
    {
           // what do
    }
}
?>
