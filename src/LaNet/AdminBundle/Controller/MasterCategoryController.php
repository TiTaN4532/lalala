<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class MasterCategoryController extends BaseController
{
    public function indexAction()
    {
        return $this->render('LaNetAdminBundle::layout.html.twig');
    }
}
