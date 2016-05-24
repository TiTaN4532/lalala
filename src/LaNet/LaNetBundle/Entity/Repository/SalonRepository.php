<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;

/**
 * SalonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SalonRepository extends EntityRepository
{
    public function findListSalons($period)
    {
             
      switch ($period) {
        case "day":
            $date= new \DateTime('-1'.$period );
            $wherePeriod =" AND u.created >= '" . $date->format('Y-m-d H:i:s'). "'";
             
        break;
     
        case "week":
            $date= new \DateTime('-1'.$period );
            $wherePeriod =" AND u.created >= '" . $date->format('Y-m-d H:i:s'). "'";
        break;
    
        case "month":
            $date= new \DateTime('-1'.$period );
            $wherePeriod =" AND u.created >= '" . $date->format('Y-m-d H:i:s'). "'";
        break;
        
        case "all":
              $wherePeriod = "";
        break;
    
        case "":
              $wherePeriod = "";
        break;
             }
                         
 $query = $this->_em->createQuery("SELECT u FROM LaNetLaNetBundle:User u WHERE u.roles LIKE '%ROLE_SALON%'" .$wherePeriod);
  

 return $query->getResult();
    }    
    
    
    public function findFilteredSalons($peginator = false, $onPage = 1, $region)
    {
      $request = Request::createFromGlobals();
      $searchterm = preg_replace('/_|%/', '\$1', $request->get('name'));
      $whereRegion = '';
      if($region) {
          $whereRegion = "l.administrative_area LIKE '%" . trim($region, '.') . "%' AND";
      } 
      $category = ($request->get('category')) ? " AND c.id = '" . $request->get('category') ."'" : "";
      $city = ($request->get('city')) ? " AND l.locality = '" . $request->get('city') ."'" : "";
      $query = $this->_em->createQuery("SELECT m, c  FROM LaNetLaNetBundle:Salon m 
                                                    LEFT JOIN m.category c     
                                                    LEFT JOIN m.location l     
                                                    WHERE " . $whereRegion . "  (m.name LIKE :like)".$category.$city)
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
