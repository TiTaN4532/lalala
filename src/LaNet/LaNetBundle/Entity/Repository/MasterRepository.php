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
    public function findFilteredMasters($peginator = false, $onPage = 1, $region = false)
    {
      $request = Request::createFromGlobals();
      $searchterm = preg_replace('/_|%/', '\$1', $request->get('name'));
      $whereRegion = '';
      if($region) {
          $whereRegion ="l.administrative_area LIKE '%" . trim($region, '.') . "%' AND";
      } 
      
      $category = ($request->get('category')) ? " AND c.id = '" . $request->get('category') ."'" : "";
      $serviceType = ($request->get('service-type')) ? " AND m.serviceType = '" . $request->get('service-type') ."'" : "";
      $city = ($request->get('city')) ? " AND l.locality = '" . $request->get('city') ."'" : "";
      $query = $this->_em->createQuery("SELECT m, c, u  FROM LaNetLaNetBundle:Master m 
                                                    LEFT JOIN m.category c     
                                                    LEFT JOIN m.location l     
                                                    LEFT JOIN m.user u     
                                                    WHERE " . $whereRegion . " (m.firstName LIKE :like OR m.lastName LIKE :like)".$category.$serviceType.$city. "ORDER BY m.inTop DESC, u.created DESC")
                          ->setParameters(array('like' => '%'.$searchterm.'%'));
                          
      if ($peginator) {
        $page = $request->query->get('page', 1);
        return $peginator->paginate($query, $page, $onPage);
      }
      else {
        return $query->getResult();
      }
    }
   
    public function findFilteredMastersOnMainPage($limit='')
    {
      $query = $this->_em->createQuery("SELECT m FROM LaNetLaNetBundle:Master m
                                                   LEFT JOIN m.user u    
                                                   WHERE m.inTop IS NOT NULL ORDER BY m.inTop DESC, u.created DESC");
        if ($limit){
        $query->setMaxResults($limit);    
        }
        return $query->getResult();
     
    }
    
    public function findFilteredMastersOnClub($limit='')
    {
      $query = $this->_em->createQuery("SELECT m FROM LaNetLaNetBundle:Master m
                                                   LEFT JOIN m.user u    
                                                   ORDER BY m.inTop DESC, u.created DESC");
        if ($limit){
        $query->setMaxResults($limit);    
        }
        return $query->getResult();
     
    }
    
    public function findListMasters($period='', $name='')
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
                         
 $query = $this->_em->createQuery("SELECT m, u FROM LaNetLaNetBundle:Master m 
                                                    LEFT JOIN m.user u     
                                                    WHERE (m.firstName LIKE :like OR m.lastName LIKE :like OR u.email LIKE :like)".$wherePeriod."ORDER BY m.inTop DESC, u.created DESC")
                    ->setParameters(array('like' => '%'.$searchterm.'%'));
                                                    
 return $query->getResult();
    }

               
      }
    
    



