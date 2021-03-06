<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use LaNet\LaNetBundle\Form\Type as LaForm;

class MainController extends BaseController
{
    public function indexAction()
    {
        $news = $this->manager->getRepository('LaNetLaNetBundle:News')->findBy(array(),array('updated' => 'DESC'),3);
        return $this->render('LaNetLaNetBundle::layout.html.twig', array('news' => $news));
    }
    
    public function generateCsrfTokenAction()
    {
      $csrf = $this->get('form.csrf_provider'); 
      $token = $csrf->generateCsrfToken(''); 
      return $this->render('LaNetLaNetBundle::token.html.twig', array('token' => $token));
    }
    
    public function customLoginFormAction(Request $request)
    {
      $session = $request->getSession();

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;

        return $this->render('LaNetLaNetBundle::login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
        ));
    }
    
    public function contactAction(Request $request) {
        $form = $this->createForm(new LaForm\ContactType());
         if ('POST' == $request->getMethod()) {
             
            $form->bind($request);

            if ($form->isValid()) {
            $data = ($form->getData());
             $message = \Swift_Message::newInstance()
                    ->setSubject($data['subject'])
                    ->setFrom($data['mail'])
                    ->setTo('info@lalook.net')
                    ->setBody(
                        $data['body']
                    )
                ;
              $this->get('mailer')->send($message);
              $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Мы прочитаем ваше сообщение!'
                );
              $this->manager->flush();

                return $this->redirect($this->generateUrl('la_net_la_net_homepage'));
            }
          }

        return $this->render('LaNetLaNetBundle::contact.html.twig',
			array('form' => $form->createView())
		);
    }
    
    public function aboutAction() {
        return $this->render('LaNetLaNetBundle::about.html.twig');
    }
   
}
