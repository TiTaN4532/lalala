<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;


class ProductRepository extends EntityRepository
{
   
    public function findFilteredProducts($peginator = false, $onPage = 1)
    {
      $request = Request::createFromGlobals();
            
      $brand = ($request->get('brand')) ? " WHERE p.brand ='" . $request->get('brand') ."'" : "";
     
      $query = $this->manager->createQuery("SELECT p FROM LaNetLaNetBundle:Product p"  .$brand);
        if ($peginator) {
        $page = $request->query->get('page', 1);
        return $peginator->paginate($query, $page, $onPage);
      }
      else {
        return $query->getResult();
      }
    }
    
    
      }
    
   