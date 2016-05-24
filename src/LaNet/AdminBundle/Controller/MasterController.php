<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class MasterController extends BaseController
{
  
  public function mainAction(Request $request)
  {
                      
     $resDay = $this->manager->getRepository('LaNetLaNetBundle:Master')->findListMasters('day');
     $resWeek = $this->manager->getRepository('LaNetLaNetBundle:Master')->findListMasters('week');
     $resMonth = $this->manager->getRepository('LaNetLaNetBundle:Master')->findListMasters('month');
     $resAll = $this->manager->getRepository('LaNetLaNetBundle:Master')->findListMasters('all');
                        
    return $this->render('LaNetAdminBundle:Master:main.html.twig', array('day' => count($resDay), 'week' => count($resWeek), 'month' => count($resMonth), 'all' => count($resAll)));
  }

  
  public function listAction(Request $request)
    {
          
        $period = $request->get('period');
        
        $page = $request->query->get('page', 1);
             
        $result = $this->manager->getRepository('LaNetLaNetBundle:Master')->findListMasters($period);
               
        $paginator = $this->paginator->paginate($result, $page, 10);
     
            
        return $this->render('LaNetAdminBundle:Master:list.html.twig', array('masters' => $paginator));
    }
    
    
    
   
    public function editAction(Request $request, $id)
    {
        $master = $this->manager->getRepository('LaNetLaNetBundle:Master')->find($id);
        
        $form = $this->createForm(new LaForm\MasterType(), $master);

        if ('POST' == $request->getMethod()) {

          $form->bind($request);

          if ($form->isValid()) {
            
            $this->manager->persist($master);
            $this->get('session')->getFlashBag()->add(
                'notice_master',
                'Ваши изменения были сохранены'
            );
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_masters_list'));
          }
        }

        return $this->render('LaNetAdminBundle:Master:edit.html.twig', array('form' => $form->createView()));
    }
    
    public function deleteAction(Request $request, $id)
    {
        $user = $this->manager->getRepository('LaNetLaNetBundle:User')->find($id);

        $this->manager->remove($user);
        
        $this->manager->flush();

        return new JsonResponse(1);
    }
    
    
}
