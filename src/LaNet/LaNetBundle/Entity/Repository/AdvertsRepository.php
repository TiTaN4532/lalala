<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;


class AdvertsRepository extends EntityRepository
{
    
     public function findListAdverts()
    {
     
        $query = $this->_em->createQuery("SELECT a FROM LaNetLaNetBundle:Adverts a 
                                                          WHERE a.is_draft IS NULL ORDER BY a.inTop DESC, a.created DESC");
                          
        return $query->getResult();
        
    }

               
     public function findListAdvertsOnMainPage($limit='')
    {
        $query = $this->_em->createQuery("SELECT a FROM LaNetLaNetBundle:Adverts a 
                                                          WHERE a.is_draft IS NULL AND a.inTop IS NOT NULL ORDER BY a.inTop DESC, a.created DESC")
                          ->setMaxResults($limit);                                                 
        
       return $query->getResult();
    }

               
      }
    
    



