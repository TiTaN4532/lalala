<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends BaseController
{
    public function listAction()
    {
                
        $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findAll();
        
        $products = $this->manager->getRepository('LaNetLaNetBundle:Product')->findFilteredProducts();
      
        return $this->render('LaNetLaNetBundle:Product:list.html.twig', array('products' => $products, 'brands' => $brands));
    }
    
 
    public function getBrandAction()
    {
       $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findAll();
       return $this->render('LaNetLaNetBundle::product.html.twig', array('brands' => $brands));
    }
    
}
