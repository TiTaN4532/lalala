<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class AgancyController extends BaseController
{
  
  public function mainAction(Request $request)
  {
     $resDay = $this->manager->getRepository('LaNetLaNetBundle:Agancy')->findListAgancy('day');
     $resWeek = $this->manager->getRepository('LaNetLaNetBundle:Agancy')->findListAgancy('week');
     $resMonth = $this->manager->getRepository('LaNetLaNetBundle:Agancy')->findListAgancy('month');
     $resAll = $this->manager->getRepository('LaNetLaNetBundle:Agancy')->findListAgancy('all');
     return $this->render('LaNetAdminBundle:Agancy:main.html.twig', array('day' => count($resDay), 'week' => count($resWeek), 'month' => count($resMonth), 'all' => count($resAll),));
  } 
     

  
  public function listAction(Request $request)
    {
        $period= $request->get('period');
        
        $page = $request->query->get('page', 1);
                
        $result= $this->manager->getRepository('LaNetLaNetBundle:Agancy')->findListAgancy($period);
               
        $paginator = $this->paginator->paginate($result, $page, 10);
      
        
        return $this->render('LaNetAdminBundle:Agancy:list.html.twig', array('agancis' => $paginator));
    }

    
       
       
    public function deleteAction(Request $request, $id)
    {
        $user = $this->manager->getRepository('LaNetLaNetBundle:User')->find($id);

        $this->manager->remove($user);
        
        $this->manager->flush();

        return new JsonResponse(1);
    }
    
}
