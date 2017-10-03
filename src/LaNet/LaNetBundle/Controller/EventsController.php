<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends BaseController
{
    public function eventsListAction()
    {
        $events = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'event', 'is_draft' => NULL),array('updated' => 'DESC'));
        
      
            $pagination = $this->paginator->paginate(
             $events, $this->getRequest()->query->get('page', 1), 10
        );
        
        return $this->render('LaNetLaNetBundle:Events:eventsList.html.twig', array('events' =>  $pagination));
    }
    
    public function eventsIdAction($slug)
    {
        $events = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findOneBy(array('slug' => $slug));
       
       /* $portfolio = $events->getPortfolio();
        foreach ( $portfolio as $port) {
             print_r ($port->getImage());
              exit();
        }
        */
           
   
        return $this->render('LaNetLaNetBundle:Events:eventsId.html.twig', array('events' => $events));
    }
}
