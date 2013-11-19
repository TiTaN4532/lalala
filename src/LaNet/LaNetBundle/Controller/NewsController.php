<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends BaseController
{
    public function newsListAction()
    {
        return $this->render('LaNetLaNetBundle:News:newsList.html.twig');
    }
}
