<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends BaseController
{
    public function newsListAction()
    {
        $news = $this->manager->getRepository('LaNetLaNetBundle:News')->findBy(array('is_draft' => NULL),array('updated' => 'DESC'));
          $pagination = $this->paginator->paginate(
             $news, $this->getRequest()->query->get('page', 1), 10
        );
        
        return $this->render('LaNetLaNetBundle:News:newsList.html.twig', array('news' => $pagination));
    }
    
    public function newsIdAction($slug)
    {
        $news = $this->manager->getRepository('LaNetLaNetBundle:News')->findOneBy(array('slug' => $slug));
        return $this->render('LaNetLaNetBundle:News:newsId.html.twig', array('news' => $news));
    }
}
