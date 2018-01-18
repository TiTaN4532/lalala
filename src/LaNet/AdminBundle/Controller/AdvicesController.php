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
            $name = $request->get('name');
            
            $advicesPosts = $this->manager->getRepository('LaNetLaNetBundle:Articles')
                ->findListArticles('advice', $name);
        
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
            
            $files = $this->getRequest()->files->get("files");
           if (!empty($files[0])) {
              foreach ($files as $file) {
                $Image =  new LaEntity\Image();
                $Image->setFile($file);
                $advicesPost->AddPortfolio ($Image);
             }
           }
            
          if ($form->get('save_draft')->isClicked()) {
              $advicesPost->setIsDraft(1);
              /*$this->get('session')->getFlashBag()->add(
                'notice_advices',
                'Ваши изменения были сохранены'
            );*/
          }
          if ($form->get('add_post')->isClicked()) {
              $this->get('session')->getFlashBag()->add(
                'notice_advices',
                'Ваши изменения были сохранены'
            );
              $advicesPost->setIsDraft(NULL);
          }
          
          $this->manager->persist($advicesPost);
                    
          /*if(!$advicesPost->getId()) {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_advices_edit', array( 'id' => $advicesPost->getId())));
          } else {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_advices'));
          }*/
          
           $this->manager->flush();
           
           if ($form->get('save_draft')->isClicked()) {
             return $this->redirect($this->generateUrl('la_net_admin_advices_edit', array( 'id' => $advicesPost->getId())));  
           }
           
           return $this->redirect($this->generateUrl('la_net_admin_advices'));
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
