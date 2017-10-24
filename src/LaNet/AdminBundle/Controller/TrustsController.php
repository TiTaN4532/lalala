<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class TrustsController extends BaseController
{
    public function trustsListAction(Request $request)
    {
            $name = $request->get('name');
            
             $trustsPosts = $this->manager->getRepository('LaNetLaNetBundle:Articles')
                ->findListArticles('trust', $name);
            
            $pagination = $this->paginator->paginate(
            $trustsPosts, $this->getRequest()->query->get('page', 1), 12
        );

        return $this->render('LaNetAdminBundle:Trusts:List.html.twig', array('pagination' => $pagination));
    }

    public function editAction(Request $request, $id = null)
    {

      $trustsRepo = $this->manager->getRepository('LaNetLaNetBundle:Articles');
     
      
      if (is_null($id)) {
        $trustsPost = new LaEntity\Articles();
      } else {
        $trustsPost = $trustsRepo->find($id);
        if (!$trustsPost) {
          throw $this->createNotFoundException('Trusts not found!');
        }
      }
      
      $form = $this->createForm(new LaForm\ArticlesType(), $trustsPost);
    
      $trustsPost->setType('trust');
      
           
        if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {
          if ($form->get('save_draft')->isClicked()) {
              $trustsPost->setIsDraft(1);
              $this->get('session')->getFlashBag()->add(
                'notice_trusts',
                'Ваши изменения были сохранены'
            );
          } 
          
           if ($form->get('add_post')->isClicked()) {
              $trustsPost->setIsDraft(NULL);
              $this->get('session')->getFlashBag()->add(
                'notice_trusts',
                'Ваши изменения были сохранены'
            );
         } 
                 
          $this->manager->persist($trustsPost);
         
          /*if(!$trustsPost->getId()) {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_trusts_edit', array( 'id' => $trustsPost->getId())));
          } else {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_trusts'));
          }*/
          
           $this->manager->flush();
           return $this->redirect($this->generateUrl('la_net_admin_trusts'));
        }
      }

        return $this->render('LaNetAdminBundle:Trusts:Edit.html.twig', array('trusts' => $trustsPost, 'form' => $form->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
      $trustsPost = $this->manager->getRepository("LaNetLaNetBundle:Articles")->findOneById($id);
      if (!$trustsPost)
        return new JsonResponse( 1 );

      $this->manager->remove($trustsPost);
      $this->manager->flush();
      $response['success'] = true;
      return new JsonResponse( $response );
    }

    public function removeImageAction(Request $request, $id) 
    {
      $trustsPost = $this->manager->getRepository('LaNetLaNetBundle:Articles')->find($id);
      unlink($trustsPost->getAbsolutePath());
      $trustsPost->setImage(null);
      $this->manager->flush();
      return new JsonResponse( 1 );
    }
    
     public function inTopAction(Request $request, $id)
    {
        $article = $this->manager->getRepository('LaNetLaNetBundle:Articles')->find($id);
       
       if ($article-> getinTop() == NULL){
           $article-> setInTop(new \DateTime());
        }
         else{
            $article-> setInTop();
         }
      
        $this->manager->persist($article);
        $this->manager->flush();

        return new JsonResponse(1);
    }
}
