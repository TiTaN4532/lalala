<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;

class BannersRepository extends EntityRepository {

    public function count($dateStart, $dateFinish) {

            if (!empty ($dateStart) AND !empty ($dateFinish)) {
            
            $datetime = new \DateTime();
            $datestart = $datetime->createFromFormat('d/m/Y', "$dateStart")->format('Y-m-d');;
            $datefinish = $datetime->createFromFormat('d/m/Y', "$dateFinish")->format('Y-m-d');
            $wherePeriod = " WHERE c.created >= '" . $datestart. "' AND c.created <= '" . $datefinish. "'";

            $query = $this->_em->createQuery("SELECT c, b, b.name AS name,  COUNT (b.id) AS cnt FROM LaNetLaNetBundle:ClickStat c
                                    LEFT JOIN c.banners b   
                                    " . $wherePeriod . " GROUP BY b.id ");
            return $query->getResult();
        } 
        
        else {

            $month = date("Y-m");
            $datestart = new \DateTime($month . -01);
            $datefinish = new \DateTime($month . -31);
            $wherePeriod = " WHERE c.created >= '" . $datestart->format('Y-m-d H:i:s') . "' AND c.created <= '" . $datefinish->format('Y-m-d H:i:s') . "'";

            $query = $this->_em->createQuery("SELECT c, b, b.name AS name,  COUNT (b.id) AS cnt FROM LaNetLaNetBundle:ClickStat c
                                    LEFT JOIN c.banners b   
                                    " . $wherePeriod . " GROUP BY b.id ");
            return $query->getResult();
        }
    }

    public function bannersShuffleAction() {
        $array = $this->_em->getRepository('LaNetLaNetBundle:Banners')->findAll();
        $keys = array_keys($array);
        shuffle($keys);
        $result = array();
        foreach ($keys as $key)
            $result[$key] = $array[$key];

        return $result;
    }
    
    public function findBannersOnMainPage($limit='') {
            
    $query = $this->_em->createQuery("SELECT b FROM LaNetLaNetBundle:Banners b 
                                                   WHERE b.is_draft IS NULL ORDER BY b.priority DESC");
        if ($limit){
            
        $query->setMaxResults($limit); 
        
        }
        return $query->getResult();
    }
    
        
    public function findBannersByGroup($group='') {
            
    $query = $this->_em->createQuery("SELECT b FROM LaNetLaNetBundle:Banners b 
                                                   WHERE b.is_draft IS NULL AND b.group_id = ".$group." ORDER BY b.priority DESC");
                
      return $query->getResult();
    }
      
 
     public function findAllBanners() {
            
    $query = $this->_em->createQuery("SELECT b FROM LaNetLaNetBundle:Banners b 
                                                   ORDER BY b.is_draft ASC, b.priority DESC");
        
        
 return $query->getResult();
    }
    
}
