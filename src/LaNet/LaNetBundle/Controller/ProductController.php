<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends BaseController
{
    public function listAction()
    {
        $request = Request::createFromGlobals();
        $brand = ($request->get('brand')) ? $request->get('brand') : "";
        $brandsCategory = $this->manager->getRepository('LaNetLaNetBundle:BrandsCategory')->findAll();
        
        //$brandCategory = $this->manager->getRepository('LaNetLaNetBundle:BrandsCategory')->findAll();
        
        $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findListBrandByBrandsCat(($request->get('category')) ? $request->get('category'):false);
             
        $product_cat = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->getProductsCategory();
        
        $product_sub_cat = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->getProductsSubCategory();
                
        $products = $this->manager->getRepository('LaNetLaNetBundle:Product')->findFilteredProducts(false, 1, $brand);
        
        $id_product_sub_cat = ($request->get('product_sub_cat')); 
        $id_product_sub_cat_array = $this->manager->getRepository('LaNetLaNetBundle:Product')->getArrayCatId($id_product_sub_cat);
               
        $selectedCategories = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->getParentId(($request->get('product_sub_cat')) ? $request->get('product_sub_cat') : "");
        
        if ( $selectedCategories)
        {
        $selectedCategories = array_reverse($selectedCategories, true);
         
        }
        return $this->render('LaNetLaNetBundle:Product:list.html.twig', array('products' => $products,
                                                                              'masterCategory' => $brandsCategory,  
                                                                              'brands' => $brands,
                                                                              'product_cat' => $product_cat,
                                                                              'product_sub_cat' => $product_sub_cat,
                                                                              'selectedCategories' => $selectedCategories));
    }
    
 
    public function getBrandAction()
    {
       $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findAll();
       return $this->render('LaNetLaNetBundle::product.html.twig', array('brands' => $brands));
    }
    
}
