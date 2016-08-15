<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;


class BannersRepository extends EntityRepository
{
   
   public function count()
              
    {
        $date= new \DateTime('-1 month' );
        $wherePeriod =" WHERE c.created >= '" . $date->format('Y-m-d H:i:s'). "'";
                               
 $query = $this->_em->createQuery("SELECT c, b, b.name AS name,  COUNT (b.id) AS cnt FROM LaNetLaNetBundle:ClickStat c
                                    LEFT JOIN c.banners b   
                                    ".$wherePeriod ." GROUP BY b.id ");
 return $query->getResult();
    }

      }
    

               
      
    
    



