<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use LaNet\LaNetBundle\Form\Type as LaForm;
use Doctrine\ORM\Query\ResultSetMapping;
use LaNet\LaNetBundle\Entity as LaEntity;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController extends BaseController {

    public function indexAction() {
        $advices = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'advice', 'is_draft' => NULL),array('updated' => 'DESC'), 8);
        $tests = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'test', 'is_draft' => NULL),array('inTop' => 'DESC', 'updated' => 'DESC'), 6);
        $trusts = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'trust', 'is_draft' => NULL),array('updated' => 'DESC'), 3);
        $events = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findBy(array('type' => 'event', 'is_draft' => NULL),array('updated' => 'DESC'), 7);
        //$news = $this->manager->getRepository('LaNetLaNetBundle:News')->findBy(array(), array('updated' => 'DESC'), 7);
        $masters = $this->manager->getRepository('LaNetLaNetBundle:Master')->findFilteredMasters($this->paginator, 5);
        $salons = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findFilteredSalons($this->paginator, 3);
      
        return $this->render('LaNetLaNetBundle::layout.html.twig', array('advices' => $advices,
                                                                         'tests' => $tests,
                                                                         'trusts' => $trusts,
                                                                         'masters' => $masters,
                                                                         'salons' => $salons,
                                                                         'events' => $events));
    }

    public function generateCsrfTokenAction() {
        $csrf = $this->get('form.csrf_provider');
        $token = $csrf->generateCsrfToken('');
        return $this->render('LaNetLaNetBundle::token.html.twig', array('token' => $token));
    }

    public function customLoginFormAction(Request $request) {
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

        $csrfToken = $this->container->has('form.csrf_provider') ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate') : null;

        return $this->render('LaNetLaNetBundle::login.html.twig', array(
                    'last_username' => $lastUsername,
                    'error' => $error,
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
//                    ->setTo('derevyanko.pav@mail.ru')
                        ->setTo('info@lalook.net')
                        ->setBody(
                        $data['body']
                        )
                ;
                $this->get('mailer')->send($message);
                $this->get('session')->getFlashBag()->add(
                        'notice', 'Мы прочитаем ваше сообщение!'
                );
                $this->manager->flush();

                return $this->redirect($this->generateUrl('la_net_la_net_homepage'));
            }
        }

        return $this->render('LaNetLaNetBundle::contact.html.twig', array('form' => $form->createView())
        );
    }

    public function aboutAction() {
        return $this->render('LaNetLaNetBundle::about.html.twig', array());
    }
    
     public function notificationsAction(Request $request)
    {
        if ($request){
            $request = $this->container->get('request');
            $mail = $request->query->get('notifications_mail'); 
            $mailRepo = $this->manager->getRepository('LaNetLaNetBundle:Notifications')->findBy(array('mail' => $mail));
            if ($mailRepo){
                return new JsonResponse('duplicate');
              }
              else{
                $newMail = new LaEntity\Notifications();

                $newMail-> setMail($mail);
                $newMail-> setActive(1);

                $this->manager->persist($newMail);
                $this->manager->flush();

              return new JsonResponse('success');
              
              }
       }
    }

}
