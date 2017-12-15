<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;


class ProductCategoryRepository extends EntityRepository
{
   
    public function getProductsCategoryOnBrand($brand='')
    {
        $request = Request::createFromGlobals();
        $brandCategory = ($request->get('category')) ? " AND brandCategory_id ='" . $request->get('category') ."'" : "";
      
        $brand = ($brand) ? " AND brand_id ='" . $brand ."'" : "";
                
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT name, id FROM product_category WHERE parent_id IS NULL". $brandCategory.$brand);
        $statement->execute();
        $result = $statement->fetchAll();    
    
        return $result;
      }
      
    public function getProductsCategory()
    {
        
        $request = Request::createFromGlobals();
        //$brandCategory = ($request->get('category')) ? " AND brandCategory_id ='" . $request->get('category') ."'" : "";
      
        $brand = ($request->get('brand')) ? " AND brand_id ='" . $request->get('brand') ."'" : "";
                
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT name, id FROM product_category WHERE parent_id IS NULL".$brand);
        $statement->execute();
        $result = $statement->fetchAll();    
    
        return $result;
      }
   
    
    public function getProductsSubCategory()
    {
        $request = Request::createFromGlobals();
        
        $parentId = ($request->get('product_cat')) ? " WHERE parent_id ='" . $request->get('product_cat') ."'" : " WHERE parent_id IS NOT NULL";
        
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT name, id FROM product_category".$parentId);
        $statement->execute();
        $result = $statement->fetchAll(); 
     
        return $result;
      }
   
      
    function getParentId($id, $allSubCat = array())
    {      
        if ($id) {
        
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT id, parent_id FROM product_category WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        $response = $statement->fetchAll();    
        
        if ($response['0']['parent_id'] !=0) {
        
        $allSubCat[$response['0']['id']] = array('sub_cat' => $this -> getAllSubCat($response['0']['parent_id']));
        }
        $idParent = $response['0']['parent_id'];
                  
        if($idParent!=0) {
           $allSubCat = $this -> getParentId($response['0']['parent_id'], $allSubCat);
        }
       
        return $allSubCat;
       
        } 
       
        return false;
}  
      

public function getAllSubCat($parentId)
    {
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT name, id FROM product_category WHERE parent_id = :id");
        $statement->bindValue('id', $parentId);
        $statement->execute();
        $result = $statement->fetchAll(); 
        return $result;
         
}   

 public function getCategory($masterCategoryId, $brandId)
    {
        
        $masterCategory = $masterCategoryId ? " AND masterCategory_id ='" .$masterCategoryId."'" : "";
      
        $brand = $brandId ? " AND brand_id ='" .$brandId."'" : "";
                
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT name, id FROM product_category WHERE parent_id IS NULL". $masterCategory.$brand);
        $statement->execute();
        $result = $statement->fetchAll();    
    
        return $result;
      }
      
 public function getBrandCategoryByCategory($CategoryId)
    {      
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT * FROM product_category WHERE parent_id IS NULL AND id = $CategoryId");
        $statement->execute();
        $result = $statement->fetchAll();    
    
        return $result;
      }
   
}
   