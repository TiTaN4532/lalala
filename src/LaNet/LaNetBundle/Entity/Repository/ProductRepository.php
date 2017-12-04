<?php

namespace LaNet\LaNetBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use LaNet\LaNetBundle\Entity;
use Symfony\Component\HttpFoundation\Request;


class ProductRepository extends EntityRepository
{
   
    public function findFilteredProducts($peginator = false, $onPage = 1, $brand='')
    {
      $request = Request::createFromGlobals();
      $searchterm = preg_replace('/_|%/', '\$1', $request->get('name'));      
      $brandCategory ='';
      $product_sub_cat = "";
      $product_cat = "";
        
      if ($request->get('category')){
        $brandCategory = "p.brandCategory ='" . $request->get('category') ."' AND ";
      }     
      
      $brand = ($brand) ? " AND p.brand ='" . $brand ."'" : "";
           
            if ($request->get('product_sub_cat')) 
                {
                                 
                 $id_product_sub_cat = $request->get('product_sub_cat');    
                 
                 $id_product_sub_cat_array = $this -> getArrayCatId($id_product_sub_cat);
                 
                 if (empty ($id_product_sub_cat_array)){
                 
                 $product_sub_cat =" AND p.category = '" .$request->get('product_sub_cat')."'";    
                 
                 }
                 
                 else {
                     
                 $product_sub_cat =" AND p.category IN (".implode(",",$id_product_sub_cat_array).")";    
                 }
                 
                 $product_cat = "";
                }
           
            else 
                 {
                 if  ($request->get('product_cat')) {
                 //$id_product_cat = $request->get('product_cat');    
                 //$id_product_cat_array = $this -> getArrayCatId($id_product_cat);
                        
                 $product_cat =" AND p.category = '" .$request->get('product_cat')."'";   
                 //$product_cat = ($request->get('product_cat')) ? " AND p.category ='" . $request->get('product_cat') ."'" : "";    
                 $product_sub_cat = "";
                }
                 }
     
     
           
      $query = $this->_em->createQuery("SELECT p FROM LaNetLaNetBundle:Product p WHERE " .$brandCategory."(p.name LIKE :like)".$brand.$product_cat.$product_sub_cat)
                                     ->setParameters(array('like' => '%'.strtolower($searchterm).'%'));
      if ($peginator) {                 
        $page = $request->query->get('page', 1);
        return $peginator->paginate($query, $page, $onPage);
      }
      else {
        return $query->getResult();
      }
    }
    
    public function findFilteredProductsByBrand($brand)
    {
        if($brand){
            
        $query = $this->_em->createQuery("SELECT p FROM LaNetLaNetBundle:Product p WHERE p.brand = $brand");
        return $query->getResult();
        }
    }
    
    
    function getArrayCatId($id, $arrayId = array())
    {      
        if ($id) 
        {
                  
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT id FROM product_category WHERE parent_id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        $response = $statement->fetchAll();    
       
        if (!empty($response)) 
            {
                        
            $id_cat = $response['0']['id'];

            $arrayId [] = $id_cat;

            if ($id_cat != 0)
                {
                   $arrayId = $this -> getArrayCatId($id_cat,  $arrayId);
                 }     
             }
       
             return $arrayId;
        } 
       
        return false;
                 
  
    }     
}
    
 