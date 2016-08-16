<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;


class BannersRepository extends EntityRepository
{
   
   public function count($date)
              
    {
       if ($date)
       {           
        $datestart= new \DateTime($date.-01);
        $datefinish= new \DateTime($date.-31);
        $wherePeriod =" WHERE c.created >= '" . $datestart->format('Y-m-d H:i:s'). "' AND c.created <= '" . $datefinish->format('Y-m-d H:i:s'). "'";
                               
 $query = $this->_em->createQuery("SELECT c, b, b.name AS name,  COUNT (b.id) AS cnt FROM LaNetLaNetBundle:ClickStat c
                                    LEFT JOIN c.banners b   
                                    ".$wherePeriod ." GROUP BY b.id ");
 return $query->getResult();
    }
    else {
        
        $month=date ("Y-m");
        $datestart= new \DateTime( $month.-01 );
        $datefinish= new \DateTime($month.-31);
        $wherePeriod =" WHERE c.created >= '" . $datestart->format('Y-m-d H:i:s'). "' AND c.created <= '" . $datefinish->format('Y-m-d H:i:s'). "'";
                               
 $query = $this->_em->createQuery("SELECT c, b, b.name AS name,  COUNT (b.id) AS cnt FROM LaNetLaNetBundle:ClickStat c
                                    LEFT JOIN c.banners b   
                                    ".$wherePeriod ." GROUP BY b.id ");
 return $query->getResult();
      }
    

}          
      
     public function getMonth($date)
    {
      if ($date)
          {
           
          $newDate = date("M", strtotime($date));
          $month=$newDate;
          
          } 
      else 
          {
           $month=date ("M"); 
              
      }    
      
      switch ($month) {
        case "Jan":
           $M='Январь';    
        break;
     
        case "Feb":
             $M='Февраль';
        break;
    
        case "Mar":
           $M='март';    
        break;
     
        case "Apr":
             $M='Апрель';
        break;
    
        case "May":
           $M='Май';    
        break;
     
        case "Jun":
             $M='Июнь';
        break;
    
        case "Jul":
           $M='Июль';    
        break;
     
        case "Aug":
             $M='Август';
        break;
    
        case "Sep":
           $M='Сентябрь';    
        break;
     
        case "Oct":
             $M='Октябрь';
        break;
    
        case "Nov":
           $M='Ноябрь';    
        break;
     
        case "Dec":
             $M='Декабрь';
        break;
             }
                         
 $result= $M;

 return $result;
    }
    
}

