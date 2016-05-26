<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class SalonController extends BaseController
{
  
  public function mainAction(Request $request)
  {
     $resDay = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findListSalons('day');
     $resWeek = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findListSalons('week');
     $resMonth = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findListSalons('month');
     $resAll = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findListSalons();
     
     return $this->render('LaNetAdminBundle:Salon:main.html.twig', array('day' => count($resDay), 'week' => count($resWeek), 'month' => count($resMonth), 'all' => count($resAll)));
  } 
      
    
  public function listAction(Request $request)
    {
      $period= $request->get('period');
      
      $page = $request->query->get('page', 1);
                
        $result= $this->manager->getRepository('LaNetLaNetBundle:Salon')->findListSalons($period);
               
        $paginator = $this->paginator->paginate($result, $page, 10);
        
        return $this->render('LaNetAdminBundle:Salon:list.html.twig', array('salons' => $paginator));
    }

       
    public function deleteAction(Request $request, $id)
    {
        $user = $this->manager->getRepository('LaNetLaNetBundle:User')->find($id);

        $this->manager->remove($user);
        
        $this->manager->flush();

        return new JsonResponse(1);
    }
    
}
