<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;


class NewsRepository extends EntityRepository
{
    
     public function findListNews($name='')
    {
      
     $searchterm = '';   
        
      if ($name){
          $searchterm = preg_replace('/_|%/', '\$1', $name);
        }
                               
 $query = $this->_em->createQuery("SELECT n FROM LaNetLaNetBundle:News n 
                                                   WHERE (n.title LIKE :like) ORDER BY n.is_draft DESC, n.inTop DESC, n.updated DESC")
                    ->setParameters(array('like' => '%'.$searchterm.'%'));
                                                    
 return $query->getResult();
    }

               
     public function findListNewsOnMainPage($limit='')
    {
                              
   $query = $this->_em->createQuery("SELECT n FROM LaNetLaNetBundle:News n 
                                                   WHERE n.is_draft is NULL ORDER BY n.inTop DESC, n.updated DESC");
        if ($limit){
        $query->setMaxResults($limit);    
        }
        
        
 return $query->getResult();
    }

               
      }
    
    



