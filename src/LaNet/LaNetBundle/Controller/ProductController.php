<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends BaseController
{
    public function listAction()
    {
        $products = $this->manager->getRepository('LaNetLaNetBundle:Product')->findAll();
        return $this->render('LaNetLaNetBundle:Product:list.html.twig', array('menuPoint' => 'product', 'products' => $products));
    }
}
