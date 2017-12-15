<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
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

    /*public function getBrand2Action(Request $request) {
        
        $request = $this->container->get('request');
        $id = $request->query->get('id');
        
         
         
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT b.id, b.name FROM brands_categories bc LEFT JOIN brand b ON b.id = bc.brand_id WHERE brandscategory_id = :id ");
        $statement->bindValue('id', $brandsCategory);
        $statement->execute();
        $response = $statement->fetchAll();      
        $response['success'] = $brandsCategory;      
      
        return new JsonResponse( $response);
      
    }*/
    
    public function getBrandAction(Request $request) {
        
        $request = $this->container->get('request');
        $brandCategory = $request->query->get('id'); 
         
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT b.name, b.id FROM brand b 
                                                   LEFT JOIN brandsS_categories bc ON b.id = bc.brand_id
                                                   WHERE brandscategory_id = :id AND b.is_draft IS NULL AND b.validation = 1 ORDER BY b.inTop DESC, b.name ASC");
        $statement->bindValue('id', $brandCategory);
        $statement->execute();
        $response = $statement->fetchAll();      
       
        return new JsonResponse( $response);
      
    }
    
    public function getBrandByBrandCatAction(Request $request) {

       
        $request = $this->container->get('request');
        $id = $request->query->get('id');
        
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT * FROM brands_categories bc WHERE brandscategory_id = :id ");
        $statement->bindValue('id', $id);
        $statement->execute();
        $response = $statement->fetchAll();      
      
        return new JsonResponse( $response);
      
    }
    
    public function getProductCategoryAction(Request $request) {

       
        $request = $this->container->get('request');
        $id_brand_category = $request->query->get('id_cat');
        $id_brand = $request->query->get('id_brand');
       
                     
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT name, id FROM product_category WHERE brand_id = :id_brand");
        //$statement->bindValue('id_cat', $id_brand_category);
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
    
    public function ratingAction(Request $request) {
        
        $id = $request->get('id');
        $cookies = $request->cookies;
        
        if ($cookies->has('myCookie2')){
            if (!empty ($cookies->get('myCookie2'))){
             $cookieMaster = $cookies->get('myCookie2');
             $cookieMaster .="m_".$id.";";
            }else{
             $cookieMaster = "m_".$id.";";
            }
        }else{
             $cookieMaster = "m_".$id.";";
        }
               
        $cookie = new Cookie('myCookie2', $cookieMaster);
        $responseCookie = new Response();
        $responseCookie->headers->setCookie($cookie);
        $responseCookie->send();
        
        $score = $request->get('rating');
        $master = $this->manager->getRepository('LaNetLaNetBundle:Master')->find($id);
        $votes = $master->getUser()->getVotes(); 
        $avgRating = $master->getUser()->getRating();   
        
        if (!$master) {
          throw $this->createNotFoundException('Master not found!');
        }
        
        else {
                   
        $score = (($avgRating*$votes)+$score)/($votes+1);
        $score = round($score, 2);
        $master->getUser()->setRating($score); 
        $master->getUser()->setVotes($votes+1);   
        $this->manager->persist($master);
        $this->manager->flush();
        
        $response['success'] = 1;
        $response['votes'] = $votes+1;
        $response['score'] = $score;
       
        }    
      
          
      return new JsonResponse($response);
      
    }   
    public function ratingBrandAction(Request $request) {
        
        $id = $request->get('id');
        $cookies = $request->cookies;
        
        if ($cookies->has('myCookie2')){
            if (!empty ($cookies->get('myCookie2'))){
             $cookieMaster = $cookies->get('myCookie2');
             $cookieMaster .="b_".$id.";";
            }else{
             $cookieMaster = "b_".$id.";";
            }
        }else{
             $cookieMaster = "b_".$id.";";
        }
               
        $cookie = new Cookie('myCookie2', $cookieMaster);
        $responseCookie = new Response();
        $responseCookie->headers->setCookie($cookie);
        $responseCookie->send();
        
        $score = $request->get('rating');
        $master = $this->manager->getRepository('LaNetLaNetBundle:Brand')->find($id);
        $votes = $master->getUser()->getVotes(); 
        $avgRating = $master->getUser()->getRating();   
        
        if (!$master) {
          throw $this->createNotFoundException('Brand not found!');
        }
        
        else {
                   
        $score = (($avgRating*$votes)+$score)/($votes+1);
        $score = round($score, 2);
        $master->getUser()->setRating($score); 
        $master->getUser()->setVotes($votes+1);   
        $this->manager->persist($master);
        $this->manager->flush();
        
        $response['success'] = 1;
        $response['votes'] = $votes+1;
        $response['score'] = $score;
       
        }    
      
          
      return new JsonResponse($response);
    }
    
    public function ratingSalonAction(Request $request) {
        
        $id = $request->get('id');
        $cookies = $request->cookies;
        
        if ($cookies->has('myCookie2')){
            if (!empty ($cookies->get('myCookie2'))){
             $cookieMaster = $cookies->get('myCookie2');
             $cookieMaster .="s_".$id.";";
            }else{
             $cookieMaster = "s_".$id.";";
            }
        }else{
             $cookieMaster = "s_".$id.";";
        }
               
        $cookie = new Cookie('myCookie2', $cookieMaster);
        $responseCookie = new Response();
        $responseCookie->headers->setCookie($cookie);
        $responseCookie->send();
        
        $score = $request->get('rating');
        $master = $this->manager->getRepository('LaNetLaNetBundle:Salon')->find($id);
        $votes = $master->getUser()->getVotes(); 
        $avgRating = $master->getUser()->getRating();   
        
        if (!$master) {
          throw $this->createNotFoundException('Salon not found!');
        }
        
        else {
                   
        $score = (($avgRating*$votes)+$score)/($votes+1);
        $score = round($score, 2);
        $master->getUser()->setRating($score); 
        $master->getUser()->setVotes($votes+1);   
        $this->manager->persist($master);
        $this->manager->flush();
        
        $response['success'] = 1;
        $response['votes'] = $votes+1;
        $response['score'] = $score;
       
        }    
      
          
      return new JsonResponse($response);
    }
    
    public function ratingSchoolAction(Request $request) {
        
        $id = $request->get('id');
        $cookies = $request->cookies;
        
        if ($cookies->has('myCookie2')){
            if (!empty ($cookies->get('myCookie2'))){
             $cookieMaster = $cookies->get('myCookie2');
             $cookieMaster .="sc_".$id.";";
            }else{
             $cookieMaster = "sc_".$id.";";
            }
        }else{
             $cookieMaster = "sc_".$id.";";
        }
               
        $cookie = new Cookie('myCookie2', $cookieMaster);
        $responseCookie = new Response();
        $responseCookie->headers->setCookie($cookie);
        $responseCookie->send();
        
        $score = $request->get('rating');
        $master = $this->manager->getRepository('LaNetLaNetBundle:School')->find($id);
        $votes = $master->getUser()->getVotes(); 
        $avgRating = $master->getUser()->getRating();   
        
        if (!$master) {
          throw $this->createNotFoundException('School not found!');
        }
        
        else {
                   
        $score = (($avgRating*$votes)+$score)/($votes+1);
        $score = round($score, 2);
        $master->getUser()->setRating($score); 
        $master->getUser()->setVotes($votes+1);   
        $this->manager->persist($master);
        $this->manager->flush();
        
        $response['success'] = 1;
        $response['votes'] = $votes+1;
        $response['score'] = $score;
       
        }    
      
          
      return new JsonResponse($response);
    }
    
    public function getBrandOnBrandsCategory()
            
     {  
        $request = Request::createFromGlobals();
        $brandsCategory = ($request->get('category')) ? $request->get('category'):false;
         
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare("SELECT b.id, b.name FROM brands_categories bc LEFT JOIN brand b ON b.id = bc.brand_id WHERE brandscategory_id = :id ");
        $statement->bindValue('id', $brandsCategory);
        $statement->execute();
        $result = $statement->fetchAll();    
    
        return $result;
     }
     
       
}
