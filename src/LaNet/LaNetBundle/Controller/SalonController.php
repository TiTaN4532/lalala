<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\HttpFoundation\Request;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;

class SalonController extends BaseController
{
    public function profileAction(Request $request)
    {
        $form = $this->createForm(new LaForm\SalonProfileType(), $this->user);

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

            return $this->redirect($this->generateUrl('la_net_la_net_salon_profile'));
        }
      }
      
        return $this->render('LaNetLaNetBundle:Salon:profile.html.twig', array('form' => $form->createView()));
    }
    
     public function profileWorkAction(Request $request)
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $salon = $this->user->getSalonInfo();
        $shcedule = $this->manager->getRepository('LaNetLaNetBundle:WorkShcedule')->findAll();
        $queryBuilder
                ->select('s.name, ms.id, ms.startTime, ms.endTime')
                ->from('LaNetLaNetBundle:SalonWorkShcedule', 'ms')
                ->leftjoin('LaNetLaNetBundle:WorkShcedule', 's',  'WITH', 'ms.shcedule = s.id')
                ->where('ms.salon = :salon')
                ->setParameter('salon', $salon)
            ;
        
        $checkedShcedule = $queryBuilder->getQuery()->getResult();
        
        $checked = array();
        foreach($checkedShcedule as $value) {
            $checked[$value['name']] = array('start' => $value['startTime'], 'end' => $value['endTime']);
        }
        foreach($shcedule as $value) {
            $shceduleTemp = new LaEntity\SalonWorkShcedule();
            $salonShcedule[] = $shceduleTemp->setSalon($salon)->setShcedule($value);
        }
        
        if ('POST' == $request->getMethod()) {
            $queryBuilder
                    ->delete('LaNetLaNetBundle:SalonWorkShcedule', 'ss')
                    ->where('ss.salon = :salon')->setParameter('salon', $salon)->getQuery()->execute();
            
            foreach($salonShcedule as $key => $value) {
                if(key_exists($value->getShcedule()->getName(), $_POST['shcedule'])) {                    
                    $sql = "INSERT INTO salons_shcedule (startTime, endTime, salon_id, shcedule_id ) VALUES ('".$_POST['start'][$value->getShcedule()->getName()]."',
                                                                                                            '".$_POST['end'][$value->getShcedule()->getName()]."',
                                                                                                            '".$salon->getId()."',
                                                                                                           '".$value->getShcedule()->getId()."'    )";
                    $stmt = $this->manager->getConnection()->prepare($sql);
                    $result = $stmt->execute();
                } 
            }
            $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
            return $this->redirect($this->generateUrl('la_net_la_net_salon_profile_work'));
      }
        return $this->render('LaNetLaNetBundle:Salon:profileWork.html.twig', array('salonShcedule' => $salonShcedule, 'checkedShcedule' => $checked));
    }
    
    public function profilePortfolioAction(Request $request)
    {
        $salon = $this->user->getSalonInfo();
        $form = $this->createForm(new LaForm\SalonPortfolioType(), $salon);
        
        if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {

          $this->manager->persist($salon);
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_salon_profile_portfolio'));
        }
      }
        return $this->render('LaNetLaNetBundle:Salon:profilePortfolio.html.twig', array('form' => $form->createView()));
    }
    
    public function profileServicePriceAction(Request $request)
    {
        $salon = $this->user->getSalonInfo();
        $form = $this->createForm(new LaForm\SalonServiceType(), $salon);
        
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
          $this->manager->persist($salon);
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_salon_profile_service_price'));
        }
      }
        return $this->render('LaNetLaNetBundle:Salon:profileServicePrice.html.twig', array('form' => $form->createView()));
    }
    
    public function listAction(Request $request)
    {
      $region = $this->getRequest()->getSession()->get('region');
      $whereRegion = '';
      if($region) {
          $whereRegion ="l.administrative_area LIKE '%" . trim($region, '.') . "%' AND ";
      } 
      $query = $this->manager->createQuery("SELECT l.locality FROM LaNetLaNetBundle:Salon s
                                                LEFT JOIN s.location l     
                                                WHERE " . $whereRegion . " l.locality != '' AND l.locality IS NOT NULL 
                                                GROUP BY l.locality");
          
      $cities = $query->getArrayResult();
      $salons = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findFilteredSalons($this->paginator, 10, $region);
      $masterCategory = $this->manager->getRepository('LaNetLaNetBundle:MasterCategory')->findAll();

      return $this->render('LaNetLaNetBundle:Salon:salonList.html.twig', array('salons' => $salons, 
                                                                                 'masterCategory' => $masterCategory, 
                                                                                 'cities' => $cities
                                                                                ));
    }
    
    public function salonIdAction(Request $request, $id)
    {
      $salon = $this->manager->getRepository('LaNetLaNetBundle:Salon')->find($id);
      if (!$salon) {
          throw $this->createNotFoundException('Salon not found!');
        }
      
      return $this->render('LaNetLaNetBundle:Salon:salonId.html.twig', array('salon' => $salon));
    }
}
