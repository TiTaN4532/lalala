<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use LaNet\AdminBundle\Form\Type as LaForm;

class MainController extends BaseController
{
    public function indexAction()
    {
        return $this->render('LaNetAdminBundle::layout.html.twig');
    }
    
    
    public function sendMailAction(Request $request) {
        $form = $this->createForm(new LaForm\ContactType());
         if ('POST' == $request->getMethod()) {
             
            $form->bind($request);

            if ($form->isValid()) {
            $data = ($form->getData());
             $message = \Swift_Message::newInstance()
                    ->setSubject($data['subject'])
                    ->setFrom('info@lalook.net')
//                    ->setTo('derevyanko.pav@mail.ru')
                    ->setTo($data['mail'])
                    ->setBody(
                        $data['body']
                    )
                ;
              $this->get('mailer')->send($message);
 /*             $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Мы прочитаем ваше сообщение!'
                );
              $this->manager->flush();
*/
 //               return $this->redirect($this->generateUrl('la_net_la_net_homepage'));
            }
          }

        return $this->render('LaNetAdminBundle:Sendmail:send.html.twig',
			array('form' => $form->createView())
		);
    }
    
   # public function sendMailAction()
   # {
   #     return $this->render('LaNetAdminBundle:Sendmail:send.html.twig');
   # }
    
    public function accessDeniedAction()
    {  
        return $this->render('LaNetAdminBundle::AccessDenied.html.twig');
    }
    
}
