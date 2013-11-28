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
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_profile'));
        }
      }
        return $this->render('LaNetLaNetBundle:Master:profile.html.twig', array('form' => $form->createView()));
    }
    
     public function profileWorkAction(Request $request)
    {
        $master = $this->user->getMasterInfo();
        $form = $this->createForm(new LaForm\MasterWorkType(), $master);
        if ('POST' == $request->getMethod()) {
          $newCategory = false;
          if(in_array('elseCategory',$request->get('lanet_prifile_work'))) {
            $request->request->set('lanet_prifile_work', array_diff($request->get('lanet_prifile_work'), array("elseCategory")));
            $newCategory = true;
          }
        $form->bind($request);
        if ($form->isValid()) {
          if($newCategory)
          {
            $data = $request->get('lanet_prifile_work');
            $category = new LaEntity\MasterCategory();
            $category->setName($data['newcategory']);
            $category->addMaster($master);
            $this->manager->persist($category);
            $master->setCategory($category);
          }
          
          $this->manager->persist($master);
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_profile_work'));
        }
      }
        return $this->render('LaNetLaNetBundle:Master:profileWork.html.twig', array('form' => $form->createView()));
    }
    
    public function profilePortfolioAction(Request $request)
    {
        $master = $this->user->getMasterInfo();
        $form = $this->createForm(new LaForm\MasterPortfolioType(), $master);
        
        if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {

          $this->manager->persist($master);
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
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
        $newServices = array();
        $requestData = $request->get('lanet_profile_service_price');
        if(isset($requestData['services'])) {
          foreach($requestData['services'] as $key => $value) {
            if(in_array('elseService',$value)) {

              $newServices[] = array_diff($value, array("elseService"));
              unset($requestData['services'][$key]);
            }
          }
        }
        $request->request->set('lanet_profile_service_price', $requestData);
        $form->bind($request);

        if ($form->isValid()) {
          if(!empty($newServices))
          {
            foreach($newServices as $key => $value) {
              print_r($value);
              if(isset($value['newservice'])) {
                $service = new LaEntity\MasterCategoryService();
                $servicePrice = new LaEntity\MasterCategoryServicePrice();
                $service->setName($value['newservice']);
                $service->setCategory($master->getCategory());
                $servicePrice->setServices($service);
                $servicePrice->setPrice($value['price']);
                $servicePrice->setMaster($master);
                $master->getCategory()->addService($service);
                $master->addService($servicePrice);
                $this->manager->persist($service);
                $this->manager->persist($servicePrice);
              }
            }
//            exit();
          }
          $this->manager->persist($master);
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
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
