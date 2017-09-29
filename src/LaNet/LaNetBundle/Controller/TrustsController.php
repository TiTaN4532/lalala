<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class TrustsController extends BaseController
{
    public function trustsListAction()
    {
        $trusts = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'trust', 'is_draft' => NULL),array('updated' => 'DESC'), 3);
        return $this->render('LaNetLaNetBundle:Trusts:trustsList.html.twig', array('trusts' => $trusts));
    }
    
    public function trustsIdAction($slug)
    {
        $trusts = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findOneBy(array('slug' => $slug));
        return $this->render('LaNetLaNetBundle:Trusts:trustsId.html.twig', array('trusts' => $trusts));
    }
}
