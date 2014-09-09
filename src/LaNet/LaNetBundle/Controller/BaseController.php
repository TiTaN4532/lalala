<?php

namespace LaNet\LaNetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LaNet\LaNetBundle\Model\InitializableControllerInterface;


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
        $this->user=$this->getUser();
    }
    
}
?>
