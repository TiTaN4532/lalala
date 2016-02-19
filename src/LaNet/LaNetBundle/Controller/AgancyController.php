<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\HttpFoundation\Request;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;

class AgancyController extends BaseController
{
    public function profileAction(Request $request)
    {
        $form = $this->createForm(new LaForm\AgancyProfileType(), $this->user);

         $agancyBrand = array();
        
        $queryBuilder = $this->manager->createQueryBuilder();
        $agancy = $this->user->getAgancyInfo();
        $queryBuilder
                ->select('b.name, ab.type, ab.oficial')
                ->from('LaNetLaNetBundle:AgancyBrand', 'ab')
                ->leftjoin('LaNetLaNetBundle:Brand', 'b',  'WITH', 'ab.brand = b.id')
                ->where('ab.agancy = :agancy')
                ->setParameter('agancy', $agancy)
            ;
        
        $checkedBrands = $queryBuilder->getQuery()->getResult();
        $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findAll();
                
        $checked = array();
        foreach($checkedBrands as $value) {
            $checked[$value['name']] = array('type' => $value['type'], 'oficial' => $value['oficial']);
        }
        foreach($brands as $value) {
            $agancyBrandsTemp = new LaEntity\AgancyBrand();
            $agancyBrand[] = $agancyBrandsTemp->setAgancy($agancy)->setBrand($value);
        }
        
        if ('POST' == $request->getMethod()) {
            if($prevLocation = $this->user->getUserInfo()->getLocation()) {
                $this->manager->remove($prevLocation);
                $this->manager->flush();
            }
        $form->bind($request);
        if ($form->isValid()) {
          $queryBuilder
                    ->delete('LaNetLaNetBundle:AgancyBrand', 'ab')
                    ->where('ab.agancy = :agancy')->setParameter('agancy', $agancy)->getQuery()->execute();

          if(isset( $_POST['brands']))
            foreach($agancyBrand as $key => $value) {
                if(key_exists($value->getBrand()->getName(), $_POST['brands'])) { 
                    $oficial = (isset($_POST['oficial'][$value->getBrand()->getName()]) ) ? $_POST['oficial'][$value->getBrand()->getName()] : '0';
                    $sql = "INSERT INTO agancy_brand (type, oficial, agancy_id, brand_id ) VALUES ('".$_POST['type'][$value->getBrand()->getName()]."',
                            '".$oficial."',
                            '".$agancy->getId()."',
                            '".$value->getBrand()->getId()."'    )";
                    $result = $this->manager->getConnection()->prepare($sql)->execute();
                } 
            }
          $this->manager->persist($this->user);
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_agancy_profile'));
        }
      }
      
        return $this->render('LaNetLaNetBundle:Agancy:profile.html.twig', array('form' => $form->createView(),
                                                                                'brands' => $agancyBrand,
                                                                                'checkedBrands' => $checked
                                                                                ));
    }
    
     public function profileWorkAction(Request $request)
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $agancy = $this->user->getAgancyInfo();
        $queryBuilder
                ->select('s.name, ags.id, ags.startTime, ags.endTime')
                ->from('LaNetLaNetBundle:AgancyWorkShcedule', 'ags')
                ->leftjoin('LaNetLaNetBundle:WorkShcedule', 's',  'WITH', 'ags.shcedule = s.id')
                ->where('ags.agancy = :agancy')
                ->setParameter('agancy', $agancy)
            ;
        
        $checkedShcedule = $queryBuilder->getQuery()->getResult();
        $queryBuilder = $this->manager->createQueryBuilder();
        $queryBuilder
                ->select('sc')
                ->from('LaNetLaNetBundle:WorkShcedule', 'sc')
                ->where("sc.name != :even")
                ->andwhere("sc.name != :odd")
                ->andwhere("sc.name != :record")
                ->setParameter('even', array('even'))
                ->setParameter('odd', array('odd'))
                ->setParameter('record', array('record'))
            ;
        
        $shcedule = $queryBuilder->getQuery()->getResult();
        
        $checked = array();
        foreach($checkedShcedule as $value) {
            $checked[$value['name']] = array('start' => $value['startTime'], 'end' => $value['endTime']);
        }
        foreach($shcedule as $value) {
            $shceduleTemp = new LaEntity\AgancyWorkShcedule();
            $agancyShcedule[] = $shceduleTemp->setAgancy($agancy)->setShcedule($value);
        }
        
        if ('POST' == $request->getMethod()) {
            $queryBuilder = $this->manager->createQueryBuilder();
            $queryBuilder
                    ->delete('LaNetLaNetBundle:AgancyWorkShcedule', 'ss')
                    ->where('ss.agancy = :agancy')->setParameter('agancy', $agancy)->getQuery()->execute();
            
            if(isset( $_POST['shcedule'])) 
                foreach($agancyShcedule as $key => $value) {
                    if(key_exists($value->getShcedule()->getName(), $_POST['shcedule'])) {                    
                        $sql = "INSERT INTO agancy_shcedule (startTime, endTime, agancy_id, shcedule_id ) VALUES ('".$_POST['start'][$value->getShcedule()->getName()]."',
                                                                                                                '".$_POST['end'][$value->getShcedule()->getName()]."',
                                                                                                                '".$agancy->getId()."',
                                                                                                               '".$value->getShcedule()->getId()."'    )";
                        $stmt = $this->manager->getConnection()->prepare($sql);
                        $result = $stmt->execute();
                    } 
                }
            $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
            return $this->redirect($this->generateUrl('la_net_la_net_agancy_profile_work'));
      }
        return $this->render('LaNetLaNetBundle:Agancy:profileWork.html.twig', array('agancyShcedule' => $agancyShcedule, 'checkedShcedule' => $checked));
    }
    
    public function profilePortfolioAction(Request $request)
    {
        $agancy = $this->user->getAgancyInfo();
        $form = $this->createForm(new LaForm\AgancyPortfolioType(), $agancy);
        
        if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {

          $this->manager->persist($agancy);
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены'
            );
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_agancy_profile_portfolio'));
        }
      }
        return $this->render('LaNetLaNetBundle:Agancy:profilePortfolio.html.twig', array('form' => $form->createView()));
    }
    
    
    public function listAction(Request $request)
    {
      $region = $this->getRequest()->getSession()->get('region');
      $whereRegion = '';
      if($region) {
          $whereRegion ="l.administrative_area LIKE '%" . trim($region, '.') . "%' AND ";
      } 
      $query = $this->manager->createQuery("SELECT l.locality FROM LaNetLaNetBundle:Agancy a
                                                LEFT JOIN a.location l     
                                                WHERE " . $whereRegion . " l.locality != '' AND l.locality IS NOT NULL 
                                                GROUP BY l.locality");
          
      $cities = $query->getArrayResult();
      $agancy = $this->manager->getRepository('LaNetLaNetBundle:Agancy')->findFilteredAgancy($this->paginator, 10, $region); 
      $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findAll();

      return $this->render('LaNetLaNetBundle:Agancy:agancyList.html.twig', array('agancy' => $agancy, 
                                                                                 'brands' => $brands,
                                                                                 'cities' => $cities,
                                                                                  ));
    }
    
    public function agancyIdAction(Request $request, $id)
    {
      $agancy = $this->manager->getRepository('LaNetLaNetBundle:Agancy')->find($id);
      if (!$agancy) {
          throw $this->createNotFoundException('Agancy not found!');
        }
      
      return $this->render('LaNetLaNetBundle:Agancy:agancyId.html.twig', array('agancy' => $agancy));
    }
}
