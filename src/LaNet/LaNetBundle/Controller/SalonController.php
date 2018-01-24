<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\HttpFoundation\Request;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;
use Symfony\Component\HttpFoundation\JsonResponse;

class SalonController extends BaseController
{
    public function profileAction(Request $request)
    {
        $form = $this->createForm(new LaForm\SalonProfileType(), $this->user);
        $valid = '';
        
        if ($this->user->getValidation() == 1) {
           $valid = 1; 
        } 
        
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
      
        return $this->render('LaNetLaNetBundle:Salon:profile.html.twig', array('form' => $form->createView(), 'valid' => $valid));
    }
    
    public function discountsAction(Request $request)
    {
      
        $discounts = $this->manager->getRepository('LaNetLaNetBundle:Discounts')->findBy(array('salon' => $this->user->getUserInfo()->getId()), array ('created' => 'DESC'));
         
        return $this->render('LaNetLaNetBundle:Salon:profileDiscounts.html.twig', array('discounts' => $discounts));
               
       }
    
    public function editAction(Request $request, $id = null)
    {
      $salon = $this->user->getUserInfo();
      $discountRepo = $this->manager->getRepository('LaNetLaNetBundle:Discounts');
     
      
      if (is_null($id)) {
        $discount = new LaEntity\Discounts();
      } else {
        $discount = $discountRepo->find($id);
        if (!$discount) {
          throw $this->createNotFoundException('Discounts not found!');
        }
      }
      
      $form = $this->createForm(new LaForm\DiscountsType(), $discount);
        
        if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {
            $discount->setIsDraft(1);
            $discount->setSalon($salon);
            $this->manager->persist($discount);
          
          
           $this->manager->flush();
           return $this->redirect($this->generateUrl('la_net_la_net_salon_profile_discounts'));
        }
      }

        return $this->render('LaNetLaNetBundle:Salon:profileDiscountsEdit.html.twig', array('discount' => $discount, 'form' => $form->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
      $discount = $this->manager->getRepository("LaNetLaNetBundle:Discounts")->findOneById($id);
      
      if (!$discount)
        return new JsonResponse( 1 );

      $this->manager->remove($discount);
      $this->manager->flush();
      $response['success'] = true;
      return new JsonResponse( $response );
    }

    public function removeImageAction(Request $request, $id) 
    {
      $discount = $this->manager->getRepository('LaNetLaNetBundle:Discounts')->find($id);
      unlink($discount->getAbsolutePath());
      $discount->setImage(null);
      $this->manager->flush();
      return new JsonResponse( 1 );
    }
    
     public function isDraftAction(Request $request, $id)
    {
        $discount = $this->manager->getRepository('LaNetLaNetBundle:Discounts')->find($id);
       
       if ($discount-> getIsDraft() == 1){
           $discount-> setIsDraft(0);
        }
         else{
            $discount-> setIsDraft(1);
         }
      
        $this->manager->persist($discount);
        $this->manager->flush();

        return new JsonResponse( 1 );
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
        $premium = $this->user->getPremium();
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
        return $this->render('LaNetLaNetBundle:Salon:profilePortfolio.html.twig', array('form' => $form->createView(), 'premium' => $premium));
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
      $brandCategory = $this->manager->getRepository('LaNetLaNetBundle:BrandsCategory')->findAll();

      return $this->render('LaNetLaNetBundle:Salon:salonList.html.twig', array('salons' => $salons, 
                                                                                 'masterCategory' => $brandCategory, 
                                                                                 'cities' => $cities
                                                                                  ));
    }
    
    public function salonIdAction(Request $request, $id)
    {
      $salon = $this->manager->getRepository('LaNetLaNetBundle:Salon')->find($id);
      $discounts = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findDiscountsByOneSalon($id);
      
      $idCookie = "s_".$id;
      $voteDisable = false;
      $cookies = $request->cookies;

       if ($cookies->has('myCookie2')){
           if (!empty ($cookies->get('myCookie2'))){
                $cookieMaster = $cookies->get('myCookie2');
                $cookieArr = explode(";",  $cookieMaster);
                    foreach ($cookieArr as $value) {
                        if ($value == $idCookie) $voteDisable = true;
                    }
            }
      } 
      
      
      if (!$salon) {
          throw $this->createNotFoundException('Salon not found!');
        }
      
      return $this->render('LaNetLaNetBundle:Salon:salonId.html.twig', array('salon' => $salon, 'discounts' => $discounts, 'voteDisable' => $voteDisable));
    }
    
    public function discountListAction(Request $request)
    {
      
        $salons = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findFilteredSalonsOnDiscountsList();
      
        foreach ($salons as $key => $salon) {
            
           $salon->discountArr = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findDiscountsByOneSalonOnDiscountsList($salon->getId());
           
        }
     
        return $this->render('LaNetLaNetBundle:Salon:discountList.html.twig', array('salons' => $salons));
    }
    
    public function profileValidationAction(Request $request)
    {
        $uniqId = $this->user->getValidation(); 
        
        if (!$uniqId){
           $uniqId = uniqid();
           $user = $this->user->setValidation($uniqId); 
           $this->manager->persist($user);
           $this->manager->flush();
        }
        
        $mail = $this->user->getEmail(); 
                
        $message = \Swift_Message::newInstance()
                     ->setSubject('Повторная валидация')
                     //->setSubject($data['subject'])
                     ->setFrom('info@lalook.net')
                     ->setTo($mail)
                     ->setBody("Здравствуйте!
                     Для валидации Вашего профиля перейдите по ссылке ниже:
                     https://lalook.net/user/validation/$uniqId

                     Вход в личный кабинет https://lalook.net/login
                      ");
             
              $this->get('mailer')->send($message);
        $respons['success'] = true;
        $respons['mail'] = $mail;
        
        return new JsonResponse($respons);
        
      }
}
