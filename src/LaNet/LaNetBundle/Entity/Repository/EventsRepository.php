<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;


class EventsRepository extends EntityRepository
{
    
     public function findList($name='')
    {
      
     $searchterm = '';   
        
      if ($name){
          $searchterm = preg_replace('/_|%/', '\$1', $name);
        }
                          
 $query = $this->_em->createQuery("SELECT e FROM LaNetLaNetBundle:UpcomingEvents e 
                                                   WHERE (e.title LIKE :like) ORDER BY e.is_draft DESC, e.updated DESC")
                    ->setParameters(array('like' => '%'.$searchterm.'%'));
                                                    
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
    
    



