<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;


class ArticlesRepository extends EntityRepository
{
    
     public function findListArticles($type='', $name='')
    {
      
     $searchterm = '';   
        
      if ($name){
          $searchterm = preg_replace('/_|%/', '\$1', $name);
        }
        
      switch ($type) {
        case "test":
           $whereType =" AND a.type = 'test' ";
        break;
     
        case "advice":
             $whereType =" AND a.type = 'advice' ";
        break;
    
        case "event":
            $whereType =" AND a.type = 'event' ";
        break;
    
        case "trust":
            $whereType =" AND a.type = 'trust' ";
        break;
            
        case "":
           $whereType =" ";
        break;
             }
                         
 $query = $this->_em->createQuery("SELECT a FROM LaNetLaNetBundle:Articles a 
                                                   WHERE (a.title LIKE :like)".$whereType."ORDER BY a.is_draft DESC, a.inTop DESC, a.updated DESC")
                    ->setParameters(array('like' => '%'.$searchterm.'%'));
                                                    
 return $query->getResult();
    }

               
     public function findListArticlesOnMainPage($type='', $limit='')
    {
            
      switch ($type) {
        case "test":
           $whereType =" AND a.type = 'test' ";
        break;
     
        case "advice":
             $whereType =" AND a.type = 'advice' ";
        break;
    
        case "event":
            $whereType =" AND a.type = 'event' ";
        break;
    
        case "trust":
            $whereType =" AND a.type = 'trust' ";
        break;
            
        case "":
           $whereType =" ";
        break;
             }
                         
 $query = $this->_em->createQuery("SELECT a FROM LaNetLaNetBundle:Articles a 
                                                   WHERE a.is_draft is NULL AND a.inTop IS NOT NULL ".$whereType."ORDER BY a.inTop DESC, a.updated DESC");
        if ($limit){
        $query->setMaxResults($limit);    
        }
        
        
 return $query->getResult();
    }
     
    public function getListArticles($type='')
    {
            
      switch ($type) {
        case "test":
           $whereType =" AND a.type = 'test' ";
        break;
     
        case "advice":
             $whereType =" AND a.type = 'advice' ";
        break;
    
        case "event":
            $whereType =" AND a.type = 'event' ";
        break;
    
        case "trust":
            $whereType =" AND a.type = 'trust' ";
        break;
            
        case "":
           $whereType =" ";
        break;
             }
                         
 $query = $this->_em->createQuery("SELECT a FROM LaNetLaNetBundle:Articles a 
                                                   WHERE a.is_draft is NULL".$whereType."ORDER BY a.inTop DESC, a.updated DESC");
         
 return $query->getResult();
    }

    
     public function  findUpcomingEventsOnMainPage ($limit='')
    {
            
        
 $query = $this->_em->createQuery("SELECT e FROM LaNetLaNetBundle:UpcomingEvents e 
                                                   WHERE e.is_draft is NULL ORDER BY e.created DESC");
        if ($limit){
        $query->setMaxResults($limit);    
        }
        
        
 return $query->getResult();
    }
          
    
               
      }
    
    



