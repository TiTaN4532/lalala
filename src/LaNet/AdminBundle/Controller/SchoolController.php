<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class SchoolController extends BaseController
{
  
  public function mainAction(Request $request)
  {
     $resDay = $this->manager->getRepository('LaNetLaNetBundle:School')->findListSchoolsByPeriod('day');
     $resWeek = $this->manager->getRepository('LaNetLaNetBundle:School')->findListSchoolsByPeriod('week');
     $resMonth = $this->manager->getRepository('LaNetLaNetBundle:School')->findListSchoolsByPeriod('month');
     $resAll = $this->manager->getRepository('LaNetLaNetBundle:School')->findListSchoolsByPeriod();
     
     return $this->render('LaNetAdminBundle:School:main.html.twig', array('day' => count($resDay), 'week' => count($resWeek), 'month' => count($resMonth), 'all' => count($resAll)));
  } 
      
    
  public function listAction(Request $request)
    {
        $name = $request->get('name');
      
        $page = $request->query->get('page', 1);
                
        $result= $this->manager->getRepository('LaNetLaNetBundle:School')->findListSchools($name);
               
        $paginator = $this->paginator->paginate($result, $page, 10);
        
        return $this->render('LaNetAdminBundle:School:list.html.twig', array('schools' => $paginator));
    }

       
    public function deleteAction(Request $request, $id)
    {
        $user = $this->manager->getRepository('LaNetLaNetBundle:User')->find($id);

        $this->manager->remove($user);
        
        $this->manager->flush();

        return new JsonResponse(1);
    }
    
      public function inTopAction(Request $request, $id)
    {
        $school = $this->manager->getRepository('LaNetLaNetBundle:School')->find($id);
       
       if ($school-> getinTop() == NULL){
            $school-> setInTop(new \DateTime());
        }
         else{
            $school-> setInTop();
         }
      
        $this->manager->persist($school);
        $this->manager->flush();

        return new JsonResponse(1);
    }
    
    public function premiumAction(Request $request, $id)
    {
        $school = $this->manager->getRepository('LaNetLaNetBundle:School')->find($id);
             
        if ($school->getUser()->getPremium() == NULL){
            $school->getUser()->setPremium(1);
        }
         else{
            $school->getUser()->setPremium(NULL);
         }
      
        $this->manager->persist($school);
        $this->manager->flush();

        return new JsonResponse(1);
    }
    
}
