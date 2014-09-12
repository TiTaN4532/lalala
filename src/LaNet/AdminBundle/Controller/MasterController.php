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
    return $this->render('LaNetAdminBundle:Master:main.html.twig', array('menuPoint' => 'masters'));
  }

  
  public function listAction(Request $request)
    {
        $page = $request->query->get('page', 1);

        $query = $this->manager->getRepository("LaNetLaNetBundle:User")->createQueryBuilder('u')
                ->select('u')
                ->where("u.roles LIKE '%ROLE_SPECIALIST%'");

        $result = $query->getQuery();
        
        $paginator = $this->paginator->paginate($result, $page, 10);
        
        return $this->render('LaNetAdminBundle:Master:list.html.twig', array('menuPoint' => 'masters', 'masters' => $paginator));
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

        return $this->render('LaNetAdminBundle:Master:edit.html.twig', array('menuPoint' => 'masters', 'form' => $form->createView()));
    }
    
    public function deleteAction(Request $request, $id)
    {
        $user = $this->manager->getRepository('LaNetLaNetBundle:User')->find($id);

        $this->manager->remove($user);
        
        $this->manager->flush();

        return new JsonResponse(1);
    }
    
    
}
