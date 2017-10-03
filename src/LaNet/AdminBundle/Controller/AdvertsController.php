<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;

class AdvertsController extends BaseController
{
    public function advertsListAction(Request $request)
    {
            $advertsPosts = $this->manager->getRepository('LaNetLaNetBundle:Adverts')
                ->findBy(array(), array('is_draft' => 'DESC', 'created' => 'DESC'));
        
            $pagination = $this->paginator->paginate(
            $advertsPosts, $this->getRequest()->query->get('page', 1), 12
        );
           

        return $this->render('LaNetAdminBundle:Adverts:List.html.twig', array('pagination' => $pagination));
    }

    public function editAction(Request $request, $id = null)
    {

      $advertsRepo = $this->manager->getRepository('LaNetLaNetBundle:Adverts');
     
      
        $advertsPost = $advertsRepo->find($id);
        if (!$advertsPost) {
          throw $this->createNotFoundException('Adverts not found!');
        }
     
      
      $form = $this->createForm(new LaForm\AdvertsType(), $advertsPost);
              
        if ('POST' == $request->getMethod()) {

        $form->bind($request);
       
        
        if ($form->isValid()) {
          if ($form->get('public')->isClicked()) {
              $advertsPost->setIsDraft(NULL);
          }
              
          $this->manager->persist($advertsPost);
          $this->get('session')->getFlashBag()->add(
                'notice_adverts',
                'Ваши изменения были сохранены'
            );
          if(!$advertsPost->getId()) {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_adverts_edit', array( 'id' => $advertsPost->getId())));
          } else {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_adverts'));
          }
        }
      }

        return $this->render('LaNetAdminBundle:Adverts:Edit.html.twig', array('adverts' => $advertsPost, 'form' => $form->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
      $advertsPost = $this->manager->getRepository("LaNetLaNetBundle:Adverts")->findOneById($id);
      if (!$advertsPost)
        return new JsonResponse( 1 );

      $this->manager->remove($advertsPost);
      $this->manager->flush();
      $response['success'] = true;
      return new JsonResponse( $response );
    }

}
