<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class TrustsController extends BaseController
{
    public function trustsListAction()
    {
        $trusts = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'trust', 'is_draft' => NULL),array('updated' => 'DESC'), 3);
         $pagination = $this->paginator->paginate(
              $trusts, $this->getRequest()->query->get('page', 1), 10
        );
        return $this->render('LaNetLaNetBundle:Trusts:trustsList.html.twig', array('trusts' => $pagination));
    }
    
    public function trustsIdAction($slug)
    {
        $trusts = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findOneBy(array('slug' => $slug));
        return $this->render('LaNetLaNetBundle:Trusts:trustsId.html.twig', array('trusts' => $trusts));
    }
}
