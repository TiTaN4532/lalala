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
        $usersFilter = array("#" => "", "0-9" => "", "A" => "a", "B" => "b", "C" => "c", "D" => "d", "E" => "e", "F" => "f", "G" => "g", "H" => "h",
                             "I" => "i", "J" => "j", "K" => "k", "L" => "l", "M" => "m", "N" => "n", "O" => "o", "P" => "p", "Q" => "q",
                              "R" => "r", "S" => "s", "T" => "t", "U" => "u", "V" => "v", "W" => "w", "X" => "x", "Y" => "y", "Z" => "z");
        return $this->render('LaNetAdminBundle:Master:list.html.twig', array('menuPoint' => 'masters', 'usersFilter' => $usersFilter));
    }
    
    public function listAjaxAction(Request $request)
    {
        $page = $request->query->get('page', 1);
        $filter = $request->get('filter') ? $request->get('filter') : '';
        
        $result = $this->manager->getRepository("LaNetLaNetBundle:Master")->findLikeName($filter);
        
        $paginator = $this->paginator->paginate($result, $page, 10);
        $paginator->setTemplate('LaNetLaNetBundle:Pagination:ajaxPager.html.twig');
        $paginator->setUsedRoute('la_net_admin_profiles_ajax');
        $paginator->setParam('filter', $filter);
        $paginator->setCustomParameters(array(
            'divId' => 'users-list'
        ));

        return $this->render('LaNetAdminBundle:Master:listAjax.html.twig', array('masters' => $paginator));
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
        $master = $this->manager->getRepository('LaNetLaNetBundle:Master')->find($id);
        
        $this->manager->remove($master->getUser());
        $this->manager->remove($master);
        
        $this->manager->flush();

        return new JsonResponse(1);
    }
    
    
}
