<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class AdvicesController extends BaseController
{
    public function advicesListAction(Request $request)
    {
            $advicesPosts = $this->manager->getRepository('LaNetLaNetBundle:Articles')
                ->findByType('advice');
        
            $pagination = $this->paginator->paginate(
            $advicesPosts, $this->getRequest()->query->get('page', 1), 12
        );

        return $this->render('LaNetAdminBundle:Advices:List.html.twig', array('pagination' => $pagination));
    }

    public function editAction(Request $request, $id = null)
    {

      $advicesRepo = $this->manager->getRepository('LaNetLaNetBundle:Articles');
     
      
      if (is_null($id)) {
        $advicesPost = new LaEntity\Articles();
      } else {
        $advicesPost = $advicesRepo->find($id);
        if (!$advicesPost) {
          throw $this->createNotFoundException('Advices not found!');
        }
      }
      
      $form = $this->createForm(new LaForm\ArticlesType(), $advicesPost);
    
      $advicesPost->setType('advice');
      
           
        if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {
          if ($form->get('save_draft')->isClicked()) {
              $advicesPost->setIsDraft(1);
          }
          if ($form->get('add_post')->isClicked()) {
              $advicesPost->setIsDraft(NULL);
          }
          
          $this->manager->persist($advicesPost);
          $this->get('session')->getFlashBag()->add(
                'notice_advices',
                'Ваши изменения были сохранены'
            );
          if(!$advicesPost->getId()) {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_advices'));
           // return $this->redirect($this->generateUrl('la_net_admin_advices_edit', array( 'id' => $advicesPost->getId())));
          } else {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_advices'));
          }
        }
      }

        return $this->render('LaNetAdminBundle:Advices:Edit.html.twig', array('advices' => $advicesPost, 'form' => $form->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
      $advicesPost = $this->manager->getRepository("LaNetLaNetBundle:Articles")->findOneById($id);
      if (!$advicesPost)
        return new JsonResponse( 1 );

      $this->manager->remove($advicesPost);
      $this->manager->flush();
      $response['success'] = true;
      return new JsonResponse( $response );
    }

    public function removeImageAction(Request $request, $id) 
    {
      $advicesPost = $this->manager->getRepository('LaNetLaNetBundle:Articles')->find($id);
      unlink($advicesPost->getAbsolutePath());
      $advicesPost->setImage(null);
      $this->manager->flush();
      return new JsonResponse( 1 );
    }
}
