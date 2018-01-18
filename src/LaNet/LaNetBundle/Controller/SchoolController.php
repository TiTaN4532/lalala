<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\HttpFoundation\Request;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;
use Symfony\Component\HttpFoundation\JsonResponse;

class SchoolController extends BaseController
{
    public function profileAction(Request $request)
    {
        $form = $this->createForm(new LaForm\SchoolProfileType(), $this->user);

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

            return $this->redirect($this->generateUrl('la_net_la_net_school_profile'));
        }
      }
      
        return $this->render('LaNetLaNetBundle:School:profile.html.twig', array('form' => $form->createView(), 'valid' => $valid));
    }
    
  
    
   
     public function profileWorkAction(Request $request)
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $school = $this->user->getSchoolInfo();
        $shcedule = $this->manager->getRepository('LaNetLaNetBundle:WorkShcedule')->findAll();
        $queryBuilder
                ->select('s.name, ms.id, ms.startTime, ms.endTime')
                ->from('LaNetLaNetBundle:SchoolWorkShcedule', 'ms')
                ->leftjoin('LaNetLaNetBundle:WorkShcedule', 's',  'WITH', 'ms.shcedule = s.id')
                ->where('ms.school = :school')
                ->setParameter('school', $school)
            ;
        
        $checkedShcedule = $queryBuilder->getQuery()->getResult();
        
        $checked = array();
        foreach($checkedShcedule as $value) {
            $checked[$value['name']] = array('start' => $value['startTime'], 'end' => $value['endTime']);
        }
        foreach($shcedule as $value) {
            $shceduleTemp = new LaEntity\SchoolWorkShcedule();
            $schoolShcedule[] = $shceduleTemp->setSchool($school)->setShcedule($value);
        }
        
        if ('POST' == $request->getMethod()) {
            $queryBuilder
                    ->delete('LaNetLaNetBundle:SchoolWorkShcedule', 'ss')
                    ->where('ss.school = :school')->setParameter('school', $school)->getQuery()->execute();
            
            foreach($schoolShcedule as $key => $value) {
                if(key_exists($value->getShcedule()->getName(), $_POST['shcedule'])) {                    
                    $sql = "INSERT INTO schools_shcedule (startTime, endTime, school_id, shcedule_id ) VALUES ('".$_POST['start'][$value->getShcedule()->getName()]."',
                                                                                                            '".$_POST['end'][$value->getShcedule()->getName()]."',
                                                                                                            '".$school->getId()."',
                                                                                                           '".$value->getShcedule()->getId()."'    )";
                    $stmt = $this->manager->getConnection()->prepare($sql);
                    $result = $stmt->execute();
                } 
            }
            $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
            return $this->redirect($this->generateUrl('la_net_la_net_school_profile_work'));
      }
        return $this->render('LaNetLaNetBundle:School:profileWork.html.twig', array('schoolShcedule' => $schoolShcedule, 'checkedShcedule' => $checked));
    }
    
    public function profilePortfolioAction(Request $request)
    {
        $School = $this->user->getSchoolInfo();
        $premium = $this->user->getPremium();
        $form = $this->createForm(new LaForm\SchoolPortfolioType(), $School);
        
        if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {

          $this->manager->persist($School);
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_school_profile_portfolio'));
        }
      }
        return $this->render('LaNetLaNetBundle:School:profilePortfolio.html.twig', array('form' => $form->createView(), 'premium' => $premium));
    }
    
    public function profileServicePriceAction(Request $request)
    {
        $School = $this->user->getSchoolInfo();
        $form = $this->createForm(new LaForm\SchoolServiceType(), $School);
        
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
          $this->manager->persist($School);
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_school_profile_service_price'));
        }
      }
        return $this->render('LaNetLaNetBundle:School:profileServicePrice.html.twig', array('form' => $form->createView()));
    }
    
    public function listAction(Request $request)
    {
      $region = $this->getRequest()->getSession()->get('region');
      $whereRegion = '';
      if($region) {
          $whereRegion ="l.administrative_area LIKE '%" . trim($region, '.') . "%' AND ";
      } 
      $query = $this->manager->createQuery("SELECT l.locality FROM LaNetLaNetBundle:School s
                                                LEFT JOIN s.location l     
                                                WHERE " . $whereRegion . " l.locality != '' AND l.locality IS NOT NULL 
                                                GROUP BY l.locality");
          
      $cities = $query->getArrayResult();
      $schools = $this->manager->getRepository('LaNetLaNetBundle:School')->findFilteredSchools($this->paginator, 10, $region);
      $brandCategory = $this->manager->getRepository('LaNetLaNetBundle:BrandsCategory')->findAll();

      return $this->render('LaNetLaNetBundle:School:schoolList.html.twig', array('schools' => $schools, 
                                                                                 'masterCategory' => $brandCategory, 
                                                                                 'cities' => $cities
                                                                                  ));
    }
    
    public function schoolIdAction(Request $request, $id)
    {
      $school = $this->manager->getRepository('LaNetLaNetBundle:School')->find($id);
     
      $idCookie = "sc_".$id;
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
      
      if (!$school) {
          throw $this->createNotFoundException('School not found!');
        }
      
      return $this->render('LaNetLaNetBundle:School:schoolId.html.twig', array('school' => $school, 'voteDisable' => $voteDisable));
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
