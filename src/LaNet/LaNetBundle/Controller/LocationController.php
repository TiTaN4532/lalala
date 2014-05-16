<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class LocationController extends BaseController
{
    public function getRegionsAction($id)
    {
      $regions = $this->manager->createQuery("SELECT r FROM LaNetLaNetBundle:Region r WHERE r.country = :id")->setParameter('id',$id)->getArrayResult();
      return new JsonResponse( $regions );
    }
    
    public function getCitiesAction($id)
    {
      $cities = $this->manager->createQuery("SELECT r FROM LaNetLaNetBundle:City r WHERE r.region = :id")->setParameter('id',$id)->getArrayResult();
      return new JsonResponse( $cities );
    }
  
}
