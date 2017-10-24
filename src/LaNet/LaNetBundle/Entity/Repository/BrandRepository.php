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
      
      public function findListBrand ($name='')
    {
      
     $searchterm = '';   
        
      if ($name){
          $searchterm = preg_replace('/_|%/', '\$1', $name);
        }
                               
        $query = $this->_em->createQuery("SELECT b FROM LaNetLaNetBundle:Brand b 
                                                   WHERE (b.name LIKE :like) ORDER BY b.is_draft DESC, b.inTop DESC, b.name ASC")
                    ->setParameters(array('like' => '%'.$searchterm.'%'));
                                                    
        return $query->getResult();
    }
      
     
      public function findListBrandByMasterCat ($name='', $masterCategory='')
   
    {   $searchterm = '';   
        if ($name){
           $searchterm = preg_replace('/_|%/', '\$1', $name);
        }
        
        $masterCat = ($masterCategory) ? " AND mc.id = '" .$masterCategory."'" : ""; 
        $query = $this->_em->createQuery("SELECT b FROM LaNetLaNetBundle:Brand b 
                                                   LEFT JOIN b.masterCategory mc 
                                                   WHERE (b.name LIKE :like) AND b.is_draft IS NULL".$masterCat." ORDER BY b.inTop DESC, b.name ASC")
                    ->setParameters(array('like' => '%'.$searchterm.'%'));

        return $query->getResult();
    }
     
      public function findListBrandOnMainPage ($limit='')
   
    {  
        $query = $this->_em->createQuery("SELECT b FROM LaNetLaNetBundle:Brand b 
                                                    WHERE b.is_draft IS NULL AND b.inTop IS NOT NULL ORDER BY b.inTop DESC, b.name ASC");
              if ($limit){
                $query->setMaxResults($limit);    
              }
        return $query->getResult();
    }
     
    
}   