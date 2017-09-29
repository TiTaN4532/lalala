<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class TestsController extends BaseController
{
    public function testsListAction()
    {
        $tests = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'test', 'is_draft' => NULL),array('updated' => 'DESC'), 3);
        return $this->render('LaNetLaNetBundle:Tests:testsList.html.twig', array('tests' => $tests));
    }
    
    public function testsIdAction($slug)
    {
        $tests = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findOneBy(array('slug' => $slug));
        return $this->render('LaNetLaNetBundle:Tests:testsId.html.twig', array('tests' => $tests));
    }
}
