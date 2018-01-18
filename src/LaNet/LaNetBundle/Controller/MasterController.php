<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;
use Symfony\Component\HttpFoundation\JsonResponse;

class MasterController extends BaseController
{
    public function profileAction(Request $request)
    {
        $form = $this->createForm(new LaForm\MasterProfileType(), $this->user);
        
        $valid = '';
        
        if ($this->user->getValidation() == 1) {
           $valid = 1; 
        } 
        
        $m_id = $this->user->getUserInfo()->getId();
        
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
        return $this->render('LaNetLaNetBundle:Master:profile.html.twig', array('form' => $form->createView(),
                                                                                'valid' => $valid,
                                                                                'm_id' => $m_id));
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
                    if($value->getShcedule()->getName() != 'record')
                        $sql = "INSERT INTO masters_shcedule (startTime, endTime, master_id, shcedule_id ) VALUES ('".$_POST['start'][$value->getShcedule()->getName()]."',
                                                                                                            '".$_POST['end'][$value->getShcedule()->getName()]."',
                                                                                                            '".$master->getId()."',
                                                                                                           '".$value->getShcedule()->getId()."'    )";
                    else
                        $sql = "INSERT INTO masters_shcedule (master_id, shcedule_id ) VALUES ('".$master->getId()."',
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
        $premium = $this->user->getPremium();
       
        
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
        return $this->render('LaNetLaNetBundle:Master:profilePortfolio.html.twig', array('premium' => $premium, 'form' => $form->createView()));
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
      
      /* $cookies = $request->cookies;

       if ($cookies->has('myCookie2'))
      {
        print_r ($cookies->get('myCookie2'));
        exit();
       } 
        
      
        
        $response = new Response();
      $cookies = $response->headers->getCookies();
        
        $cookie = $request->cookies->get('myCookie');
      print_r ($cookies);
      exit();
        */
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

      $masterOrder = $this->manager->getRepository('LaNetLaNetBundle:Master')-> findBy(array(), array ('inTop' => 'DESC'));
      
      
      return $this->render('LaNetLaNetBundle:Master:masterList.html.twig', array('masters' =>  $masters, 
                                                                                 'masterCategory' => $masterCategory, 
                                                                                 'cities' => $cities,
                                                                                  ));
    }
    
    public function mainListAction(Request $request)
    {
     
      $masters = $this->manager->getRepository('LaNetLaNetBundle:Master')->findFilteredMastersOnClub(10);
      $salons = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findFilteredSalonsOnMainPage();
      $schools = $this->manager->getRepository('LaNetLaNetBundle:School')->findFilteredSchoolsOnMainPage();
      
      return $this->render('LaNetLaNetBundle::clubMain.html.twig', array('masters' =>  $masters, 
                                                                         'salons' =>  $salons,
                                                                         'schools' =>  $schools));
    }
    
    public function masterIdAction(Request $request, $id)
    {
      $idCookie = "m_".$id;
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
        
      
     $master = $this->manager->getRepository('LaNetLaNetBundle:Master')->find($id);
      if (!$master) {
          throw $this->createNotFoundException('Master not found!');
        }
      
      return $this->render('LaNetLaNetBundle:Master:masterId.html.twig', array('master' => $master, 'voteDisable' => $voteDisable));
    }
    
    public function profileValidationAction(Request $request)
    {
        $uniqId = $this->user->getValidation(); 
        
        if (!$uniqId){
           $uniqId = uniqid();
           $master = $this->user->setValidation($uniqId); 
           $this->manager->persist($master);
           $this->manager->flush();
        }
        
        $mail = $this->user->getEmail(); 
        
        /*$message = \Swift_Message::newInstance()
                     ->setSubject('Повторная валидация')
                     //->setSubject($data['subject'])
                     ->setFrom('info@lalook.net')
                     ->setTo($mail)
                     ->setBody("Здравствуйте!
                     Для валидации Вашего профиля перейдите по ссылке ниже:
                     https://lalook.net/user/validation/$uniqId

                     Вход в личный кабинет https://lalook.net/login
                      ");
             
              $this->get('mailer')->send($message);*/
        $respons['success'] = true;
        $respons['mail'] = $mail;
        
        return new JsonResponse($respons);
        
      }
    
}
