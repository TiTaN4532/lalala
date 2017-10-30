<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;


class BrandController extends BaseController
{
    public function brandListAction(Request $request)
    {
       
        $testsTop = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findListArticlesOnMainPage('test');
        $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findListBrandByMasterCat($request->get('name'), $request->get('category'));
        $SiteSettings = $this->manager->getRepository('LaNetLaNetBundle:SiteSettings')->findBy(array('name' => 'LaLook'));
        $masterCategory = $this->manager->getRepository('LaNetLaNetBundle:MasterCategory')->findAll();
       
        $brandPost = new LaEntity\Brand();
        $brandForm = $this->createForm(new LaForm\BrandType(), $brandPost);
        
        if ('POST' == $request->getMethod()) {

         $brandForm->bind($request);
         
         if ( $brandForm->isValid()) {
              $uniqId = uniqid();
              $brandPost->setIsDraft(1);
              $brandPost->setValidation($uniqId);
              
              $this->manager->persist($brandPost);
              
               $data = ($brandForm->getData());
                             
               $message = \Swift_Message::newInstance()
                    ->setSubject('Подтверждение регистрации бренда')
                    //->setSubject($data['subject'])
                    ->setFrom('info@lalook.net')
                    ->setTo($data->getMail())
                    ->setBody("Здравствуйте!
                    Вы зарегестрировали бренд на сайте http://lalook.net

                    Для завершения регистрации перейдите по ссылке ниже
                    http://lalook.net/brands/validation/$uniqId
                     ");
                        //$this->renderView('LaNetAdminBundle:Sendmail:validation.html.twig', array('uniqId' => $uniqId)), 'text/html');
               
                $this->manager->flush();
              
               
              //return $this->render('LaNetAdminBundle:Sendmail:validation.html.twig', array('uniqId' => $uniqId));  
               
              $this->get('mailer')->send($message);
              $this->get('session')->getFlashBag()->add(
                    'notice_brand_main',
                    'На указанную вами почту выслано письмо с подтверждением регистрации. Для активации нужно перейти по ссылке указаной в письме.
                     Обратите внимание: письмо может попасть в папку "Спам", рекомендуем обязательно её проверить.'             
                      );
             $this->manager->flush();
            
            }
             return $this->redirect($this->generateUrl('la_net_la_net_brands_list'));
                         
            }
        
        $pagination = $this->paginator->paginate(
             $brands, $this->getRequest()->query->get('page', 1), 10
        );
            
        
        
        return $this->render('LaNetLaNetBundle:Brand:brandList.html.twig', array('brands' => $pagination,
                                                                                 'SiteSettings' => $SiteSettings,
                                                                                 'testsTop' => $testsTop,
                                                                                 'masterCategory' => $masterCategory,
                                                                                 'form' => $brandForm->createView()));
    }
    
    public function brandIdAction($slug)
    {
        $brand = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findOneBy(array('slug' => $slug));
        return $this->render('LaNetLaNetBundle:Brand:brandId.html.twig', array('brand' => $brand));
    }
    
    public function validationAction($uniqId)
    {   
        $brand = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findOneBy(array('validation' => $uniqId));
        $validStatus = ' ';
            if (!is_null($brand)){
                $brand->setValidation(1);
                $this->manager->persist($brand);

                $this->manager->flush();
                $validStatus = true;
            }

            else{
                  $validStatus = false;      
            }
        
        return $this->render('LaNetLaNetBundle:Brand:valid.html.twig', array('validStatus' => $validStatus));
    
    }
    
    
    
    
    
}
