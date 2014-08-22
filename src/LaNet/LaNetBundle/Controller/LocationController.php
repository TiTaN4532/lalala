<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class LocationController extends BaseController
{
    public function getRegionsAction()
    {
      $regions = $this->manager->createQuery("SELECT r FROM LaNetLaNetBundle:Region r WHERE r.country_id = 9908" )->getResult();
      return $this->render('LaNetLaNetBundle::regions.html.twig', array('regions' => $regions));
    }
    
    public function setRegionAction(Request $request)
    {
      $session = $this->getRequest()->getSession();
      $session->set('region', $request->request->get('regions'));

        
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }
  
}
