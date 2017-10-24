<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;

class AdvertsController extends BaseController
{
    public function advertsListAction(Request $request)
    {
        $advertsList = $this->manager->getRepository('LaNetLaNetBundle:Adverts')->findBy(array('is_draft' => NULL),array('created' => 'DESC'));
       
       
            $pagination = $this->paginator->paginate(
            $advertsList, $this->getRequest()->query->get('page', 1), 5
        );
            
           /*  
             $page = $request->query->get('page', 1);
        $pagination = $peginator->paginate($advertsPosts, $page, 1);
            
            */
        
        $advertsPost = new LaEntity\Adverts();
        $advertsForm = $this->createForm(new LaForm\AdvertsType(), $advertsPost);
       
        $newMail = new LaEntity\Notifications();

            
        if ('POST' == $request->getMethod()) {

        $advertsForm->bind($request);

            if ($advertsForm->isValid()) {
             $advertsPost->setIsDraft(1);
                
                $newMail-> setMail($advertsForm->getData()->getMail());
                $newMail-> setName($advertsForm->getData()->getName());
                $newMail-> setActive(0);
                             
              $this->manager->persist($newMail);
              
              $this->manager->persist($advertsPost);
              $this->get('session')->getFlashBag()->add(
                    'notice_adverts',
                    'Ваше объявление сохранено и будет опубликовано после проверки модератором'             
                      );
              $this->manager->flush();
            
            }
             return $this->redirect($this->generateUrl('la_net_la_net_adverts_list'));
                         
            }
         
           
           
        return $this->render('LaNetLaNetBundle:Adverts:advertsList.html.twig', array('advertsList' => $pagination, 'form' => $advertsForm->createView()));
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

    
    
    public function eventsIdAction($slug)
    {
        $events = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findOneBy(array('slug' => $slug));
        return $this->render('LaNetLaNetBundle:Events:eventsId.html.twig', array('events' => $events));
    }
}
