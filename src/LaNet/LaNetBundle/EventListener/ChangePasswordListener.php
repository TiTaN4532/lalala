<?php

namespace LaNet\LaNetBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class ChangePasswordListener implements EventSubscriberInterface {
    private $router;
    private $user;

    public function __construct(UrlGeneratorInterface $router, $context) {
        $this->router = $router;
        if($context->getToken())
            $this->user = $context->getToken()->getUser();
    }

    public static function getSubscribedEvents() {
        return [
            FOSUserEvents::CHANGE_PASSWORD_SUCCESS => 'onChangePasswordSuccess',
        ];
    }

    public function onChangePasswordSuccess(FormEvent $event) {
        if ($this->user->hasRole('ROLE_SPECIALIST')) {
            $url = $this->router->generate('la_net_la_net_master_profile');
        } elseif ($this->user->hasRole('ROLE_CONSUMER')) {
            $url = $this->router->generate('la_net_la_net_consumer_profile');
        } elseif ($this->user->hasRole('ROLE_SALON')) {
            $url = $this->router->generate('la_net_la_net_homepage');
        } elseif ($this->user->hasRole('ROLE_AGANCY')) {
            $url = $this->router->generate('la_net_la_net_homepage');
        } elseif ($this->user->hasRole('ROLE_SHOP')) {
            $url = $this->router->generate('la_net_la_net_homepage');
        } elseif ($this->user->hasRole('ROLE_SCHOOL_CENTER')) {
            $url = $this->router->generate('la_net_la_net_homepage');
        }
        $event->setResponse(new RedirectResponse($url));
    }
}