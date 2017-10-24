<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class SiteSettingsController extends BaseController
{
    public function editAction(Request $request)
    {

      $settings = $this->manager->getRepository('LaNetLaNetBundle:SiteSettings');
      $siteSettings = $this->manager->getRepository('LaNetLaNetBundle:SiteSettings')->findOneBy(array('name' => 'LaLook'));
      
      if (empty ($siteSettings)){
         $id = null;
         
      }
      else{
         $id = $siteSettings->getId();
       
      }
      
       if ($id == null) {
        $settings = new LaEntity\SiteSettings();
       
      } else {
       $settings = $settings->find($id);
        if (!$settings) {
          throw $this->createNotFoundException('SiteSettings not found!');
        }
      }
      
      $form = $this->createForm(new LaForm\SiteSettingsType(),  $settings);
    
      if ('POST' == $request->getMethod()) {
           
        $form->bind($request);

        if ($form->isValid()) {
         
          if ($form->get('save')->isClicked()) {
              $settings->setName('LaLook');
              $this->get('session')->getFlashBag()->add(
                'notice_site_settings',
                'Ваши изменения были сохранены'
            );
          }
           
          $this->manager->persist($settings);
          $this->manager->flush();
          
          return $this->redirect($this->generateUrl('la_net_admin_site_settings'));
        }
      }

        return $this->render('LaNetAdminBundle:SiteSettings:Edit.html.twig', array('settings' => $settings, 'form' => $form->createView()));
    }

}
