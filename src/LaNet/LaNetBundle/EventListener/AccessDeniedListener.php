<?php

namespace LaNet\LaNetBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Router;

// Show access denied page

class AccessDeniedListener
{
   
  private $router;
  
  public function __construct(Router $router)
  {
      $this->router = $router;
  }
  public function onAccessDeniedException(GetResponseForExceptionEvent $event)
  {
    $exception = $event->getException();
    //Get the root cause of the exception.
    while (null !== $exception->getPrevious()) {
      $exception = $exception->getPrevious();
    }
    if ($exception instanceof AccessDeniedException) {
        $response = new RedirectResponse($this->router->generate('lanet_main_access_denied'));
        $event->setResponse($response);
    }
  }
}