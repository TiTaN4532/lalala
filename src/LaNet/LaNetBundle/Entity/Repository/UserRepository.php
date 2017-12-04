<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;


class UserRepository extends EntityRepository
{
    
    
    public function findByyRole($like)
    {
      if($like)
          $like = " WHERE m.roles LIKE '%".$like."%' ";

      $query = $this->_em->createQuery("SELECT m FROM LaNetLaNetBundle:User m ".$like);
        
      return $query->getResult();
    }
}
