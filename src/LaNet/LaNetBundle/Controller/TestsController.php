<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class TestsController extends BaseController
{
    public function testsListAction(Request $request)
    {
       // $testsTop = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'test', 'is_draft' => NULL, 'inTop' => () ), array('inTop' => 'DESC', 'updated' => 'DESC'));
        
        $searchterm = preg_replace('/_|%/', '\$1', $request->get('name'));
        /*if ( $searchterm) {
        print_r ($searchterm);
        exit();
        }*/
        
        $qb =  $this->manager->createQueryBuilder(); 
        $testsTop = $qb->select("t")
        ->from("LaNetLaNetBundle:Articles", "t")
        ->where("t.type = 'test'")
        ->andwhere($qb->expr()->isNotNull("t.inTop"))
        ->andwhere($qb->expr()->isNull("t.is_draft"))
        ->orderBy('t.inTop', 'DESC')
        ->orderBy('t.updated', 'DESC')
                
        ->getQuery()->getResult();
        
        
        
        
          
        $qb =  $this->manager->createQueryBuilder(); 
        $tests = $qb->select("t")
        ->from("LaNetLaNetBundle:Articles", "t")
        ->where("t.type = 'test'")
         ->andwhere( $qb->expr()->like('t.title', $qb->expr()->literal('%'.$searchterm.'%')) )
        ->andwhere($qb->expr()->isNull("t.is_draft"))
        ->orderBy('t.inTop', 'DESC')
        ->orderBy('t.updated', 'DESC')
                
        ->getQuery()->getResult();
        
        
        
       // $tests = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'test', 'is_draft' => NULL),array('inTop' => 'DESC', 'updated' => 'DESC'));
       
        
            $pagination = $this->paginator->paginate(
            $tests, $this->getRequest()->query->get('page', 1), 10
        );
        
        return $this->render('LaNetLaNetBundle:Tests:testsList.html.twig', array('tests' => $pagination, 'tests2' => $tests, 'testsTop' => $testsTop));
    }
    
    public function testsIdAction($slug)
    {
        $tests = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findOneBy(array('slug' => $slug));
        return $this->render('LaNetLaNetBundle:Tests:testsId.html.twig', array('tests' => $tests));
    }
}
