<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class BrandController extends BaseController
{
    public function brandListAction()
    {
        $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findAll();
        return $this->render('LaNetLaNetBundle:Brand:brandList.html.twig', array('brands' => $brands,
                
                                                                                 'menuPoint' => 'brand'));
    }
    
    public function brandIdAction($slug)
    {
        $brand = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findOneBy(array('slug' => $slug));
        return $this->render('LaNetLaNetBundle:Brand:brandId.html.twig', array('brand' => $brand, 'menuPoint' => 'brand'));
    }
}
