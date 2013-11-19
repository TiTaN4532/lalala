<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class MainController extends BaseController
{
    public function indexAction()
    {
        return $this->render('LaNetAdminBundle::layout.html.twig', array('menuPoint' => 'details'));
    }
    public function accessDeniedAction()
    {  
        return $this->render('LaNetAdminBundle::AccessDenied.html.twig');
    }
    
}
