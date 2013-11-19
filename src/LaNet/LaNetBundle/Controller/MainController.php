<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends BaseController
{
    public function indexAction()
    {
        $news = $this->manager->getRepository('LaNetLaNetBundle:News')->findBy(array(),array('updated' => 'DESC'),3);
        return $this->render('LaNetLaNetBundle::layout.html.twig', array('news' => $news));
    }
    
    public function generateCsrfTokenAction()
    {
      $csrf = $this->get('form.csrf_provider'); 
      $token = $csrf->generateCsrfToken(''); 
      return $this->render('LaNetLaNetBundle::token.html.twig', array('token' => $token));
    }
}
