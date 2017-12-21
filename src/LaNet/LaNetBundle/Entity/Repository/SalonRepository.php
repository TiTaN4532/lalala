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
    public function findListSalons($period ='', $name = '')
    {
       
     $searchterm = '';   
        
      if ($name){
          $searchterm = preg_replace('/_|%/', '\$1', $name);
        }
        
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
              $wherePeriod = " ";
        break;
             }
                         
 $query = $this->_em->createQuery("SELECT s, u FROM LaNetLaNetBundle:Salon s 
                                                    LEFT JOIN s.user u     
                                                    WHERE (s.name LIKE :like OR u.email LIKE :like)".$wherePeriod."ORDER BY s.inTop DESC, u.created DESC")
                    ->setParameters(array('like' => '%'.$searchterm.'%'));
                             

 return $query->getResult();
    }    
    
    public function findFilteredSalonsOnMainPage($limit='')
    {
      $query = $this->_em->createQuery("SELECT s FROM LaNetLaNetBundle:Salon s
                                                   LEFT JOIN s.user u    
                                                   WHERE s.inTop IS NOT NULL ORDER BY s.inTop DESC, s.name ASC");
            if ($limit){
                $query->setMaxResults($limit);    
            }
        return $query->getResult();
     
    }
    
    public function findFilteredSalonsOnDiscountsList()
    {
       $request = Request::createFromGlobals();
       $searchterm = preg_replace('/_|%/', '\$1', $request->get('name'));
        
       $query = $this->_em->createQuery("SELECT s FROM LaNetLaNetBundle:Salon s
                                                   LEFT JOIN s.discounts d    
                                                   WHERE (s.name LIKE :like) AND d.is_draft != 1 GROUP BY s.id ORDER BY s.inTop DESC")
            ->setParameters(array('like' => '%'.$searchterm.'%'));
            
        return $query->getResult();
     
    }
    /*public function findFilteredSalonsOnDiscountsList()
    {
       $request = Request::createFromGlobals();
       $searchterm = preg_replace('/_|%/', '\$1', $request->get('name'));
        
       $query = $this->_em->createQuery("SELECT s FROM LaNetLaNetBundle:Discounts d
                                                   LEFT JOIN d.salon s    
                                                   WHERE (s.name LIKE :like) GROUP BY s.id ORDER BY s.inTop DESC")
            ->setParameters(array('like' => '%'.$searchterm.'%'));
            
        return $query->getResult();
     
    }*/
    
    
    
    public function findDiscountsBySalon()
    {
      $query = $this->_em->createQuery("SELECT s.name, s.id, COUNT (d.id) as cnt FROM LaNetLaNetBundle:Discounts d
                                                   LEFT JOIN d.salon s    
                                                   GROUP BY s.name ORDER BY s.name DESC");
           
        return $query->getResult();
     
    }
    
    public function findDiscountsByOneSalon($id)
    {
      $query = $this->_em->createQuery("SELECT s, d FROM LaNetLaNetBundle:Discounts d
                                                   LEFT JOIN d.salon s    
                                                   WHERE s.id = '" .$id. "' ORDER BY d.inTop DESC");
           
        return $query->getResult();
     
    }
    
    public function findDiscountsByOneSalonOnDiscountsList($id)
    {
      $query = $this->_em->createQuery("SELECT d FROM LaNetLaNetBundle:Discounts d
                                                   LEFT JOIN d.salon s    
                                                   WHERE s.id = '" .$id. "' ORDER BY d.inTop DESC");
           
        return $query->getResult();
     
    }
    
    public function findDiscountsOnMainPage($limit='')
    {
      $query = $this->_em->createQuery("SELECT s, d FROM LaNetLaNetBundle:Discounts d
                                                   LEFT JOIN d.salon s    
                                                   WHERE d.inTop IS NOT NULL AND d.is_draft = 0 ORDER BY d.inTop DESC");
           
      if ($limit){
                $query->setMaxResults($limit);    
            }  
      return $query->getResult();
     
    }
    
    public function findFilteredSalons($peginator = false, $onPage = 1, $region = false)
    {
      $request = Request::createFromGlobals();
      $searchterm = preg_replace('/_|%/', '\$1', $request->get('name'));
      $whereRegion = '';
      if($region) {
          $whereRegion = "l.administrative_area LIKE '%" . trim($region, '.') . "%' AND";
      } 
      $category = ($request->get('category')) ? " AND c.id = '" . $request->get('category') ."'" : "";
      $city = ($request->get('city')) ? " AND l.locality = '" . $request->get('city') ."'" : "";
      $query = $this->_em->createQuery("SELECT s, c  FROM LaNetLaNetBundle:Salon s 
                                                    LEFT JOIN s.category c     
                                                    LEFT JOIN s.location l
                                                    LEFT JOIN s.user u 
                                                    WHERE " . $whereRegion . "  (s.name LIKE :like)".$category.$city. "ORDER BY s.inTop DESC, s.name ASC")
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
