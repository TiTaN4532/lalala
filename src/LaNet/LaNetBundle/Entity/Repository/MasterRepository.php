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
}