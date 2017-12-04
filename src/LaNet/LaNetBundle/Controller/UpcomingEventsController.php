<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;

class UpcomingEventsController extends BaseController
{
    public function eventsListAction(Request $request)
    {
        $eventsList = $this->manager->getRepository('LaNetLaNetBundle:UpcomingEvents')->findBy(array('is_draft' => NULL),array('created' => 'DESC'));
        $pagination = $this->paginator->paginate(
            $eventsList, $this->getRequest()->query->get('page', 1), 5
        );
        
        $eventsPost = new LaEntity\UpcomingEvents();
        $eventsForm = $this->createForm(new LaForm\UpcomingEventsType(), $eventsPost);
        if ('POST' == $request->getMethod()) {

        $eventsForm->bind($request);

            if ($eventsForm->isValid()) {
            
                $eventsPost->setIsDraft(1);
                
              $this->manager->persist($eventsPost);
              $this->get('session')->getFlashBag()->add(
                    'notice_upcoming_events',
                    'Событие сохранено и будет опубликовано после проверки модератором'             
                      );
              $this->manager->flush();
            
            }
             return $this->redirect($this->generateUrl('la_net_la_net_upcoming_events_list'));
                         
            }
         
           
           
        return $this->render('LaNetLaNetBundle:UpcomingEvents:eventsList.html.twig', array('eventsList' => $pagination, 'form' => $eventsForm->createView()));
    }
    
    
    public function eventsIdAction($slug)
    {
        $events = $this->manager->getRepository('LaNetLaNetBundle:UpcomingEvents')->findOneBy(array('slug' => $slug));
        return $this->render('LaNetLaNetBundle:UpcomingEvents:eventsId.html.twig', array('events' => $events));
    }
    
    
    
    
    
}
