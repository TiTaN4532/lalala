<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\HttpFoundation\Request;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;

class MasterController extends BaseController
{
    public function profileAction(Request $request)
    {
        $form = $this->createForm(new LaForm\MasterProfileType(), $this->user);
        
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

            return $this->redirect($this->generateUrl('la_net_la_net_master_profile'));
        }
      }
        return $this->render('LaNetLaNetBundle:Master:profile.html.twig', array('form' => $form->createView()));
    }
    
     public function profileWorkAction(Request $request)
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $master = $this->user->getMasterInfo();
        $shcedule = $this->manager->getRepository('LaNetLaNetBundle:WorkShcedule')->findAll();
        $queryBuilder
                ->select('s.name, ms.id, ms.startTime, ms.endTime')
                ->from('LaNetLaNetBundle:MasterWorkShcedule', 'ms')
                ->leftjoin('LaNetLaNetBundle:WorkShcedule', 's',  'WITH', 'ms.shcedule = s.id')
                ->where('ms.master = :master')
                ->setParameter('master', $master)
            ;
        
        $checkedShcedule = $queryBuilder->getQuery()->getResult();
        
        $checked = array();
        foreach($checkedShcedule as $value) {
            $checked[$value['name']] = array('start' => $value['startTime'], 'end' => $value['endTime']);
        }
        foreach($shcedule as $value) {
            $shceduleTemp = new LaEntity\MasterWorkShcedule();
            $masterShcedule[] = $shceduleTemp->setMaster($master)->setShcedule($value);
        }
        
        if ('POST' == $request->getMethod()) {
            $queryBuilder
                    ->delete('LaNetLaNetBundle:MasterWorkShcedule', 'ms')
                    ->where('ms.master = :master')->setParameter('master', $master)->getQuery()->execute();
            
            foreach($masterShcedule as $key => $value) {
                if(key_exists($value->getShcedule()->getName(), $_POST['shcedule'])) {                    
                    $sql = "INSERT INTO masters_shcedule (startTime, endTime, master_id, shcedule_id ) VALUES ('".$_POST['start'][$value->getShcedule()->getName()]."',
                                                                                                            '".$_POST['end'][$value->getShcedule()->getName()]."',
                                                                                                            '".$master->getId()."',
                                                                                                           '".$value->getShcedule()->getId()."'    )";
                    $stmt = $this->manager->getConnection()->prepare($sql);
                    $result = $stmt->execute();
                } 
            }
            $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
            return $this->redirect($this->generateUrl('la_net_la_net_master_profile_work'));
      }
        return $this->render('LaNetLaNetBundle:Master:profileWork.html.twig', array('masterShcedule' => $masterShcedule, 'checkedShcedule' => $checked));
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

            return $this->redirect($this->generateUrl('la_net_la_net_master_profile_portfolio'));
        }
      }
        return $this->render('LaNetLaNetBundle:Master:profilePortfolio.html.twig', array('form' => $form->createView()));
    }
    
    public function profileServicePriceAction(Request $request)
    {
        $master = $this->user->getMasterInfo();
        $form = $this->createForm(new LaForm\MasterServiceType(), $master);
        
        if ('POST' == $request->getMethod()) {
//        $newServices = array();
//        $requestData = $request->get('lanet_profile_service_price');
//        if(isset($requestData['services'])) {
//          foreach($requestData['services'] as $key => $value) {
//            if(in_array('elseService',$value)) {
//
//              $newServices[] = array_diff($value, array("elseService"));
//              unset($requestData['services'][$key]);
//            }
//          }
//        }
//        $request->request->set('lanet_profile_service_price', $requestData);
        $form->bind($request);
        if ($form->isValid()) {
//          if(!empty($newServices))
//          {
//            foreach($newServices as $key => $value) {
//              if(isset($value['newservice'])) {
//                $service = new LaEntity\MasterCategoryService();
//                $servicePrice = new LaEntity\MasterCategoryServicePrice();
//                $service->setName($value['newservice']);
//                $service->setCategory($master->getCategory());
//                $servicePrice->setServices($service);
//                $servicePrice->setPrice($value['price']);
//                $servicePrice->setMaster($master);
//                $master->getCategory()->addService($service);
//                $master->addService($servicePrice);
//                $this->manager->persist($service);
//                $this->manager->persist($servicePrice);
//              }
//            }
////            exit();
//          }
          $this->manager->persist($master);
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_master_profile_service_price'));
        }
      }
        return $this->render('LaNetLaNetBundle:Master:profileServicePrice.html.twig', array('form' => $form->createView()));
    }
    
    public function listAction(Request $request)
    {
      $region = $this->getRequest()->getSession()->get('region');
      $whereRegion = '';
      if($region) {
          $whereRegion ="l.administrative_area LIKE '%" . trim($region, '.') . "%' AND ";
      } 
      $query = $this->manager->createQuery("SELECT l.locality FROM LaNetLaNetBundle:Master m
                                                LEFT JOIN m.location l     
                                                 WHERE " . $whereRegion . " l.locality != '' AND l.locality IS NOT NULL
                                                GROUP BY l.locality");
          
      $cities = $query->getArrayResult();
      $masters = $this->manager->getRepository('LaNetLaNetBundle:Master')->findFilteredMasters($this->paginator, 10, $region);
      $masterCategory = $this->manager->getRepository('LaNetLaNetBundle:MasterCategory')->findAll();

      return $this->render('LaNetLaNetBundle:Master:masterList.html.twig', array('masters' => $masters, 
                                                                                 'masterCategory' => $masterCategory, 
                                                                                 'cities' => $cities,
                                                                                ));
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
