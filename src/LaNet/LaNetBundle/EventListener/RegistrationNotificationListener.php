<?php
namespace LaNet\LaNetBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Security\Core\SecurityContext;  
use Symfony\Component\Routing\Router;  
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;  
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;  
use Symfony\Component\EventDispatcher\EventDispatcher;  
use Symfony\Component\HttpKernel\KernelEvents;  
   
class RegistrationNotificationListener  
{  
protected $router;  
protected $security;  
protected $dispatcher;  
   
public function __construct(Router $router, SecurityContext $security, EventDispatcher $dispatcher)  
{  
$this->router = $router;  
$this->security = $security;  
$this->dispatcher = $dispatcher;  
}  
   
public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)  
{  
$this->dispatcher->addListener(KernelEvents::RESPONSE, array($this,'onKernelResponse'));  
}  
   
public function onKernelResponse(FilterResponseEvent $event)  
{  
if ($this->security->isGranted('ROLE_ADMIN')){  
$response = new RedirectResponse($this->router->generate('la_net_admin_homepage'));  
} else {  
$response = new RedirectResponse($this->router->generate('la_net_la_net_homepage'));  
}  
$event->setResponse($response);  
}  

}

