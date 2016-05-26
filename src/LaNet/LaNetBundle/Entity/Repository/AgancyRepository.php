<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;

/**
 * AgancyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AgancyRepository extends EntityRepository
{
       
    public function findListAgancy($period='')
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
    
        case "":
              $wherePeriod = "";
        break;
             }
                         
 $query = $this->_em->createQuery("SELECT u FROM LaNetLaNetBundle:User u WHERE u.roles LIKE '%ROLE_AGANCY%'" .$wherePeriod);
  

 return $query->getResult();
    }
    

     
    public function findFilteredAgancy($peginator = false, $onPage = 1, $region)
    {
      $request = Request::createFromGlobals();
      $searchterm = preg_replace('/_|%/', '\$1', $request->get('name'));
      $whereRegion = '';
      if($region) {
          $whereRegion = "l.administrative_area LIKE '%" . trim($region, '.') . "%' AND";
      } 
      $brand = ($request->get('brand')) ? " AND ab.brand = '" . $request->get('brand') ."'" : "";
      $city = ($request->get('city')) ? " AND l.locality = '" . $request->get('city') ."'" : "";
      $query = $this->_em->createQuery("SELECT a, ab  FROM LaNetLaNetBundle:Agancy a 
                                                    LEFT JOIN a.agancyBrand ab     
                                                    LEFT JOIN a.location l     
                                                    WHERE " . $whereRegion . "  (a.name LIKE :like)".$brand.$city)
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
