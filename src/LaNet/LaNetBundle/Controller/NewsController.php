<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends BaseController
{
    public function newsListAction()
    {
        $news = $this->manager->getRepository('LaNetLaNetBundle:News')->findBy(array(),array('updated' => 'DESC'));
        return $this->render('LaNetLaNetBundle:News:newsList.html.twig', array('news' => $news));
    }
    
    public function newsIdAction($slug)
    {
        $news = $this->manager->getRepository('LaNetLaNetBundle:News')->findOneBy(array('slug' => $slug));
        return $this->render('LaNetLaNetBundle:News:newsId.html.twig', array('news' => $news));
    }
}
