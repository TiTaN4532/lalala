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
    return $this->render('LaNetAdminBundle:Salon:main.html.twig', array('menuPoint' => 'salons'));
  }

  
  public function listAction(Request $request)
    {
        $page = $request->query->get('page', 1);
                
        $query = $this->manager->getRepository("LaNetLaNetBundle:User")->createQueryBuilder('u')
                ->select('u')
                ->where("u.roles LIKE '%ROLE_SALON%'");

        $result = $query->getQuery();
       
        $paginator = $this->paginator->paginate($result, $page, 10);
        
        return $this->render('LaNetAdminBundle:Salon:list.html.twig', array('menuPoint' => 'salons', 'salons' => $paginator));
    }

       
    public function deleteAction(Request $request, $id)
    {
        $user = $this->manager->getRepository('LaNetLaNetBundle:User')->find($id);

        $this->manager->remove($user);
        
        $this->manager->flush();

        return new JsonResponse(1);
    }
    
}
