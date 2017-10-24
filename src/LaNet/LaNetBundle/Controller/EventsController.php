<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends BaseController
{
    public function eventsListAction()
    {
        
        $newArray = array();
        $currentMonth = '';
       
        $events = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'event', 'is_draft' => NULL),array('created' => 'DESC'));
       
        foreach ($events as $event ) {
            if ($event->getCreated()->format('F') ==  $currentMonth){
                
                $currentYear = $event->getCreated()->format('Y');
                $newArray[$currentMonth.'-'. $currentYear][] = $event;
                $currentMonth = $event->getCreated()->format('F');
            } 
            else {
                $currentMonth = $event->getCreated()->format('F');
                $currentYear = $event->getCreated()->format('Y');
                $newArray[$currentMonth.'-'. $currentYear][] = $event;
            }
        }
        
        
            $pagination = $this->paginator->paginate(
             $events, $this->getRequest()->query->get('page', 1), 10
        );
            
              $pagination2 = $this->paginator->paginate(
             $newArray, $this->getRequest()->query->get('page', 1), 10
        );
        
        return $this->render('LaNetLaNetBundle:Events:eventsList.html.twig', array('events' =>  $pagination, 'newArray' => $pagination2));
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
