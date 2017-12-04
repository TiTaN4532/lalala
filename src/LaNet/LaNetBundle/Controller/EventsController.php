<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class EventsController extends BaseController
{
    public function eventsListAction()
    {
        setlocale(LC_ALL, "ru_RU.utf8", "ru_RU");
        
        $newArray = array();
        $currentMonth = '';
       
        $events = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'event', 'is_draft' => NULL),array('date' => 'DESC'));
        
        
        
        foreach ($events as $event ) {
            if ($event->getDate() == NULL){
                 $date = $event->getCreated();
            }
            else {
                $date = $event->getDate();
            }
                       
            $month = strftime("%B", $date->getTimestamp());
            if ($month ==  $currentMonth){
               
                $currentYear = $date->format('Y');
                $newArray[$currentMonth.'-'. $currentYear][] = $event;
                $currentMonth = $month;
            } 
            else {
                $currentMonth = $month;
                $currentYear = $date->format('Y');
                $newArray[$currentMonth.'-'. $currentYear][] = $event;
            }
        }
        
            
              $pagination = $this->paginator->paginate(
             $newArray, $this->getRequest()->query->get('page', 1), 10
        );
        
        return $this->render('LaNetLaNetBundle:Events:eventsList.html.twig', array('newArray' => $pagination));
    }
    
    public function eventsIdAction($slug)
    {
        $events = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findOneBy(array('slug' => $slug));
       
                
   
        return $this->render('LaNetLaNetBundle:Events:eventsId.html.twig', array('events' => $events));
    }
    
    
    
     public function getEventWithVideoAction(Request $request) {

       
        $request = $this->container->get('request');
        $id = $request->query->get('id');
        $events = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findOneBy(array('id' => $id));
               
        $respons['date'] = $events->getCreated()->format('d.m.Y');
                
        $linkNew=false;
        
        if ($events){
           $link = $events->getVideo();
  
            if ($link) {
                $pattern ='%embed[^? | "]+%';
                preg_match($pattern, $link, $matches);

                if ($matches){
                    $linkNew = mb_strcut ($matches[0], 6);
                }
            }
        }
        $respons['video'] = $linkNew;
        
        /*        
        print_r ($events->getId());
        exit();*/
           
        return new JsonResponse($respons);
      
    }
    
    
    
    
}
