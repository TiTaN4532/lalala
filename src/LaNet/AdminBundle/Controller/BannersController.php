<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class BannersController extends BaseController
{
    public function mainAction(Request $request)
  {
       
    return $this->render('LaNetAdminBundle:Banners:main.html.twig');
  }
    
  
   public function statAction(Request $request)
  {
       
        $date= $request->get('startDate');
       
   $banners = $this->manager->getRepository('LaNetLaNetBundle:Banners')-> count($date);       
        $pagination = $this->paginator->paginate(
            $banners, $this->getRequest()->query->get('page', 1), 1000
        );   
       
        
        $month = $this->manager->getRepository('LaNetLaNetBundle:Banners')-> getMonth($date);
        
        
   return $this->render('LaNetAdminBundle:Banners:stat.html.twig', array('pagination' => ($pagination), 'date' => $month));

  }
 
  
    public function listAction(Request $request)
    {
        $banners = $this->manager->getRepository('LaNetLaNetBundle:Banners')
                ->findAll();
        $pagination = $this->paginator->paginate(
            $banners, $this->getRequest()->query->get('page', 1), 1000
        );
        
               
        return $this->render('LaNetAdminBundle:Banners:list.html.twig', array('pagination' => $pagination));
    }

    public function editAction(Request $request, $id = null)
    {

      $newsRepo = $this->manager->getRepository('LaNetLaNetBundle:Banners');
      if (is_null($id)) {
        $banners = new LaEntity\Banners();
      } else {
        $banners = $newsRepo->find($id);
        if (!$banners) {
          throw $this->createNotFoundException('Banners not found!');
        }
      }
      $form = $this->createForm(new LaForm\BannersType(), $banners);

      if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {
          $this->manager->persist($banners);
          $this->get('session')->getFlashBag()->add(
                'notice_banners',
                'Ваши изменения были сохранены'
            );
          
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_banners_list'));
        }
      }   
      
        return $this->render('LaNetAdminBundle:Banners:edit.html.twig', array('banners' => $banners, 'form' => $form->createView()));
    }

   /* public function deleteAction(Request $request, $id)
    {
      $banners = $this->manager->getRepository("LaNetLaNetBundle:Banners")->findOneById($id);
      if (!$banners)
        return new JsonResponse( 1 );
      if($banners->getProduct()->isEmpty()) {
        $this->manager->remove($banners);
        $this->manager->flush();
        $response['success'] = true;
      } else {
        $response['success'] = false;
      }
      return new JsonResponse( $response );
    } */

    public function removeImageAction(Request $request, $id) 
    {
      $banners = $this->manager->getRepository('LaNetLaNetBundle:Banners')->find($id);
      unlink($banners->getAbsolutePath());
      $newsPost->setImage(null);
      $this->manager->flush();
      return new JsonResponse( 1 );
    }
    
    
    public function bannersShuffleAction()
    {
      $array = $this->manager->getRepository('LaNetLaNetBundle:Banners')->findAll();      
      $keys = array_keys($array);
      shuffle($keys);
      $result = array();
    foreach ($keys as $key)
    $result[$key] = $array[$key];

    return $this->render('LaNetLaNetBundle::banners.html.twig', array('banners' => $result));
      
    }
    
     public function CountAction($id)  
    
   {    
       $em = $this->getDoctrine()->getManager();
           
       $banner = $em->getRepository('LaNetLaNetBundle:Banners')->find($id);
       
       $clickStat = new LaEntity\ClickStat ();
              
       $banner -> setClick($banner->getClick() + 1);
  
       $clickStat->setIdNum(2);     
       
       $clickStat ->setBanners($banner);
       
       $em->persist($clickStat);
       
       $em->flush();
       
       return $this->redirect($banner->getLink());
      
   }
  
    
}
