<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class AdvicesController extends BaseController
{
    public function advicesListAction()
    {
        $advices = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'advice', 'is_draft' => NULL),array('updated' => 'DESC'), 3);
        return $this->render('LaNetLaNetBundle:Advices:advicesList.html.twig', array('advices' => $advices));
    }
    
    public function advicesIdAction($slug)
    {
        $advices = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findOneBy(array('slug' => $slug));
        return $this->render('LaNetLaNetBundle:Advices:advicesId.html.twig', array('advices' => $advices));
    }
}
