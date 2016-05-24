<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends BaseController
{
    public function listAction()
    {
                
        $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findAll();
        
        $products = $this->findFilteredProducts();
               
        return $this->render('LaNetLaNetBundle:Product:list.html.twig', array('products' => $products, 'brands' => $brands));
    }



    public function findFilteredProducts()
    {
      $request = Request::createFromGlobals();
            
      $brand = ($request->get('brand')) ? " WHERE p.brand ='" . $request->get('brand') ."'" : "";
     
      $query = $this->manager->createQuery("SELECT p FROM LaNetLaNetBundle:Product p"  .$brand);
        
        return $query->getResult();
      
    }
 
    public function getBrandAction()
    {
       $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findAll();
       return $this->render('LaNetLaNetBundle::product.html.twig', array('brands' => $brands));
    }
    
}
