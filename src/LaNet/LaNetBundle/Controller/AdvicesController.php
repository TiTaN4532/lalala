<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class AdvicesController extends BaseController
{
    public function advicesListAction()
    {
        $advices = $this->manager->getRepository('LaNetLaNetBundle:Articles')->getListArticles('advice');
        $pagination = $this->paginator->paginate(
               $advices, $this->getRequest()->query->get('page', 1), 10
        );
        return $this->render('LaNetLaNetBundle:Advices:advicesList.html.twig', array('advices' =>  $pagination));
    }
    
    public function advicesIdAction($slug)
    {
        $advices = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findOneBy(array('slug' => $slug));
        return $this->render('LaNetLaNetBundle:Advices:advicesId.html.twig', array('advices' => $advices));
    }
}
