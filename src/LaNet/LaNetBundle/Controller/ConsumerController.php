<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;

class ConsumerController extends BaseController
{
    public function profileAction(Request $request)
    {
        $form = $this->createForm(new LaForm\ConsumerProfileType(), $this->user);
         
        if ('POST' == $request->getMethod()) {
        if($prevLocation = $this->user->getUserInfo()->getLocation()) {
            $this->manager->remove($prevLocation);
            $this->manager->flush();
        }
        $form->bind($request);

        if ($form->isValid()) {

          $this->manager->persist($this->user);
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
          
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_consumer_profile'));
        }
      }
     
        return $this->render('LaNetLaNetBundle:Consumer:profile.html.twig', array('form' => $form->createView()));
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
