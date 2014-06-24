<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;


class MasterRepository extends EntityRepository
{
    public function findLikeName($like)
    {
      if($like)
          $like = " WHERE m.lastName LIKE '".$like."%' ";

      $query = $this->_em->createQuery("SELECT m FROM LaNetLaNetBundle:Master m ".$like);
        
      return $query->getResult();
    }
    public function findFilteredMasters($peginator = false, $onPage = 1)
    {
      $request = Request::createFromGlobals();
      $searchterm = preg_replace('/_|%/', '\$1', $request->get('name'));
      $category = ($request->get('category')) ? " AND c.id = '" . $request->get('category') ."'" : "";
      $serviceType = ($request->get('service-type')) ? " AND m.serviceType = '" . $request->get('service-type') ."'" : "";
      $query = $this->_em->createQuery("SELECT m, c  FROM LaNetLaNetBundle:Master m 
                                                    LEFT JOIN m.category c     
                                                    WHERE (m.firstName LIKE :like OR m.lastName LIKE :like)".$category.$serviceType)
                          ->setParameters(array('like' => '%'.$searchterm.'%'));
      if ($peginator) {
        $page = $request->query->get('page', 1);
        return $peginator->paginate($query, $page, $onPage);
      }
      else {
        return $query->getResult();
      }
    }
}