<?php

namespace LaNet\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LaNet\LaNetBundle\Model\InitializableControllerInterface;
use Symfony\Component\HttpFoundation\Request;


// Base user controller class to initialize general properties 


abstract class BaseController extends Controller implements InitializableControllerInterface
{
    protected $user;
    protected $user_manager;
    protected $manager;
    protected $session;
    protected $paginator;


    public function __init()
    {
        $this->user_manager=$this->get('fos_user.user_manager');
        $this->session=$this->get('session');
        $this->manager=$this->getDoctrine()->getManager();
        $this->paginator = $this->get('knp_paginator');
        $this->user=$this->get('security.context')->getToken()->getUser();
    }
    
    public function cityAction($city = null)
    {
        $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')
                ->findAll();
        $pagination = $this->paginator->paginate(
            $brands, $this->getRequest()->query->get('page', 1), 1000
        );

        return $this->render('LaNetAdminBundle::city.html.twig', array('countries' => 'brand', 'pagination' => $pagination));
    }
}
?>
