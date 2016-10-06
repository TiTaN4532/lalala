<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query\ResultSetMapping;
use LaNet\LaNetBundle\Entity as LaEntity;
use Symfony\Component\HttpFoundation\JsonResponse;

class MenuController extends BaseController {

   
    
    public function getMasterCategoryAction() {

        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT id, name FROM master_category");
        $statement->execute();
        $categories = $statement->fetchAll();

        return $this->render('LaNetLaNetBundle::MasterCategory.html.twig', array('categories' => $categories));
    }

    public function getBrandAction(Request $request) {

       
        $request = $this->container->get('request');
        $id = $request->query->get('id');
        
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT b.id, b.name FROM brands_categories bc LEFT JOIN brand b ON b.id = bc.brand_id WHERE mastercategory_id = :id ");
        $statement->bindValue('id', $id);
        $statement->execute();
        $response = $statement->fetchAll();      
      
        return new JsonResponse( $response);
      
    }
    
    public function getProductCategoryAction(Request $request) {

       
        $request = $this->container->get('request');
        $id_master_category = $request->query->get('id_cat');
        $id_brand = $request->query->get('id_brand');
       
                     
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT name, id FROM product_category WHERE masterCategory_id = :id_cat AND brand_id = :id_brand");
        $statement->bindValue('id_cat', $id_master_category);
        $statement->bindValue('id_brand',  $id_brand);
        $statement->execute();
        $response = $statement->fetchAll();
           
        return new JsonResponse( $response);
      
    }
    
    public function getProductSubCategoryAction(Request $request) {

       
        $request = $this->container->get('request');
        $id_parent = $request->query->get('id_parent');
                             
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT name, id FROM product_category WHERE parent_id = :id");
        $statement->bindValue('id', $id_parent);
        $statement->execute();
        $response = $statement->fetchAll();
 
            
      
      return new JsonResponse( $response);
      
    }   

}
