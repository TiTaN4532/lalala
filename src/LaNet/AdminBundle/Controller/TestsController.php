<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class TestsController extends BaseController
{
    public function testsListAction(Request $request)
    {
            $name = $request->get('name');
            
            $testsPosts = $this->manager->getRepository('LaNetLaNetBundle:Articles')
                ->findListArticles('test', $name);
            
            $pagination = $this->paginator->paginate(
            $testsPosts, $this->getRequest()->query->get('page', 1), 12
        );

        return $this->render('LaNetAdminBundle:Tests:List.html.twig', array('pagination' => $pagination));
    }

    public function editAction(Request $request, $id = null)
    {

      $testsRepo = $this->manager->getRepository('LaNetLaNetBundle:Articles');
     
      
      if (is_null($id)) {
        $testsPost = new LaEntity\Articles();
        $testsPost->setType('test');
      } else {
        $testsPost = $testsRepo->find($id);
        if (!$testsPost) {
          throw $this->createNotFoundException('Tests not found!');
        }
      }
      
      $form = $this->createForm(new LaForm\ArticlesType(), $testsPost);
    
    
      
           
        if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {
          if ($form->get('save_draft')->isClicked()) {
              $testsPost->setIsDraft(1);
              $this->get('session')->getFlashBag()->add(
                'notice_tests',
                'Ваши изменения были сохранены'
            );
          }
          if ($form->get('add_post')->isClicked()) {
              $testsPost->setIsDraft(NULL);
              $this->get('session')->getFlashBag()->add(
                'notice_tests',
                'Ваши изменения были сохранены'
            );
          }
        
          $this->manager->persist($testsPost);
         
          /*if(!$testsPost->getId()) {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_tests_edit', array( 'id' => $testsPost->getId())));
          } else {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_tests'));
          }*/
          
          $this->manager->flush();
          return $this->redirect($this->generateUrl('la_net_admin_tests'));
        }
      }

        return $this->render('LaNetAdminBundle:Tests:Edit.html.twig', array('tests' => $testsPost, 'form' => $form->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
      $testsPost = $this->manager->getRepository("LaNetLaNetBundle:Articles")->findOneById($id);
      if (!$testsPost)
        return new JsonResponse( 1 );

      $this->manager->remove($testsPost);
      $this->manager->flush();
      $response['success'] = true;
      return new JsonResponse( $response );
    }

    public function removeImageAction(Request $request, $id) 
    {
      $testsPost = $this->manager->getRepository('LaNetLaNetBundle:Articles')->find($id);
      unlink($testsPost->getAbsolutePath());
      $testsPost->setImage(null);
      $this->manager->flush();
      return new JsonResponse( 1 );
    }
    
    public function inTopAction(Request $request, $id)
    {
        $tests = $this->manager->getRepository('LaNetLaNetBundle:Articles')->find($id);
       
       if ($tests-> getinTop() == NULL){
            $tests-> setInTop(new \DateTime());
        }
         else{
            $tests-> setInTop();
         }
      
        $this->manager->persist($tests);
        $this->manager->flush();

        return new JsonResponse(1);
    }
    
}
