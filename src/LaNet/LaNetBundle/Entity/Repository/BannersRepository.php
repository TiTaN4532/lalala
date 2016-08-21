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

    
}
