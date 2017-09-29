<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class EventsController extends BaseController
{
    public function eventsListAction(Request $request)
    {
            $eventsPosts = $this->manager->getRepository('LaNetLaNetBundle:Articles')
                ->findByType('event');
        
            $pagination = $this->paginator->paginate(
            $eventsPosts, $this->getRequest()->query->get('page', 1), 12
        );

        return $this->render('LaNetAdminBundle:Events:List.html.twig', array('pagination' => $pagination));
    }

    public function editAction(Request $request, $id = null)
    {

      $eventsRepo = $this->manager->getRepository('LaNetLaNetBundle:Articles');
     
      
      if (is_null($id)) {
        $eventsPost = new LaEntity\Articles();
      } else {
        $eventsPost = $eventsRepo->find($id);
        if (!$eventsPost) {
          throw $this->createNotFoundException('Events not found!');
        }
      }
      
      $form = $this->createForm(new LaForm\ArticlesType(), $eventsPost);
    
      $eventsPost->setType('event');
      
           
        if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {
          if ($form->get('save_draft')->isClicked()) {
              $eventsPost->setIsDraft(1);
          }
          if ($form->get('add_post')->isClicked()) {
              $eventsPost->setIsDraft(NULL);
          }
         
          $this->manager->persist($eventsPost);
          $this->get('session')->getFlashBag()->add(
                'notice_events',
                'Ваши изменения были сохранены'
            );
          if(!$eventsPost->getId()) {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_events_edit', array( 'id' => $eventsPost->getId())));
          } else {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_events'));
          }
        }
      }

        return $this->render('LaNetAdminBundle:Events:Edit.html.twig', array('events' => $eventsPost, 'form' => $form->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
      $eventsPost = $this->manager->getRepository("LaNetLaNetBundle:Articles")->findOneById($id);
      if (!$eventsPost)
        return new JsonResponse( 1 );

      $this->manager->remove($eventsPost);
      $this->manager->flush();
      $response['success'] = true;
      return new JsonResponse( $response );
    }

    public function removeImageAction(Request $request, $id) 
    {
      $eventsPost = $this->manager->getRepository('LaNetLaNetBundle:Articles')->find($id);
      unlink($eventsPost->getAbsolutePath());
      $eventsPost->setImage(null);
      $this->manager->flush();
      return new JsonResponse( 1 );
    }
}
