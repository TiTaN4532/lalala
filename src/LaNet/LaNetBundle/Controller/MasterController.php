<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;

class MasterController extends BaseController
{
    public function profileAction(Request $request)
    {
        $master = $this->user->getMasterInfo();
        $form = $this->createForm(new LaForm\MasterProfileType(), $master);
        
        if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {

          $this->manager->persist($master);
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_profile'));
        }
      }
        return $this->render('LaNetLaNetBundle:Master:profile.html.twig', array('form' => $form->createView()));
    }
    
    public function profilePortfolioAction(Request $request)
    {
        $master = $this->user->getMasterInfo();
        $form = $this->createForm(new LaForm\MasterPortfolioType(), $master);
        
        if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {

          $this->manager->persist($master);
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_profile_portfolio'));
        }
      }
        return $this->render('LaNetLaNetBundle:Master:profilePortfolio.html.twig', array('form' => $form->createView()));
    }
    
    public function profileServicePriceAction(Request $request)
    {
        $master = $this->user->getMasterInfo();
        $form = $this->createForm(new LaForm\MasterServiceType($master), $master);
        
        if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {
          $this->manager->persist($master);
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_profile_service_price'));
        }
      }
        return $this->render('LaNetLaNetBundle:Master:profileServicePrice.html.twig', array('form' => $form->createView()));
    }
    
    public function listAction(Request $request)
    {
      $masters = $this->manager->getRepository('LaNetLaNetBundle:Master')->findAll();
      
      return $this->render('LaNetLaNetBundle:Master:masterList.html.twig', array('masters' => $masters));
    }
    
    public function masterIdAction(Request $request, $id)
    {
      $master = $this->manager->getRepository('LaNetLaNetBundle:Master')->find($id);
      if (!$master) {
          throw $this->createNotFoundException('Master not found!');
        }
      
      return $this->render('LaNetLaNetBundle:Master:masterId.html.twig', array('master' => $master));
    }
}
