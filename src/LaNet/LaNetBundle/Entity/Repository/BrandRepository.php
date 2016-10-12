<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;


class BrandRepository extends EntityRepository
{
      
     public function getBrandOnMasterCategory ()
            
     {  
        $request = Request::createFromGlobals();
        $masterCategory = ($request->get('category')) ? $request->get('category'):false;
         
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT b.id, b.name FROM brands_categories bc LEFT JOIN brand b ON b.id = bc.brand_id WHERE mastercategory_id = :id ");
        $statement->bindValue('id', $masterCategory);
        $statement->execute();
        $result = $statement->fetchAll();    
    
        return $result;
        
      
}

     public function getBrandList ($id)
            
     {  
        
        $masterCategory = $id ? $id:false;
         
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT b.id, b.name FROM brands_categories bc LEFT JOIN brand b ON b.id = bc.brand_id WHERE mastercategory_id = :id ");
        $statement->bindValue('id', $masterCategory);
        $statement->execute();
        $result = $statement->fetchAll();    
    
        return $result;
        
      }
    
}   