<?php

namespace LaNet\LaNetBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\Request;
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
      return array(FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted', FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialise');
    }

    public function onRegistrationCompleted( $event)
    {
    
     $user = $event->getUser();
     
     $uniqId = $user->getValidation();   
    
    //$email = $user->getEmail();
     
    
     /*$form = $event->getForm();
     $email = $form['email']->getData();*/
     
     $email = 'alexx.aleksandroff@gmail.com';
     
            $message = \Swift_Message::newInstance()
                     ->setSubject('Подтверждение регистрации')
                     //->setSubject($data['subject'])
                     ->setFrom('info@lalook.net')
                     ->setTo($email)
                     ->setBody("Здравствуйте!
                     Вы зарегестрировались на сайте http://lalook.net

                     Для завершения регистрации перейдите по ссылке ниже
                     http://lalook.net/user/validation/$uniqId

                     Вход в личный кабинет http://lalook.net/login
                      ");
     
                     $this->container->get('mailer')->send($message);
                     
           /* $message = \Swift_Message::newInstance()
                    ->setSubject('Thanks')
                    ->setFrom('info@lalook.net')
                    ->setTo($email)
                    ->setBody('message')
                   ;
              $this->container->get('mailer')->send($message);*/
 
   
    }
    
    public function onRegistrationInitialise( UserEvent $event )
    {
     $user = $event->getUser();
     
     $uniqId = uniqid();
     
     $user->setValidation($uniqId);     
    }
}
?>
