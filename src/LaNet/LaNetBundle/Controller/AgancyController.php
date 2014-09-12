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

            return $this->redirect($this->generateUrl('la_net_la_net_agancy_profile'));
        }
      }
      
        return $this->render('LaNetLaNetBundle:Agancy:profile.html.twig', array('form' => $form->createView()));
    }
    
     public function profileWorkAction(Request $request)
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $agancy = $this->user->getAgancyInfo();
        $shcedule = $this->manager->getRepository('LaNetLaNetBundle:WorkShcedule')->findAll();
        $queryBuilder
                ->select('s.name, ags.id, ags.startTime, ags.endTime')
                ->from('LaNetLaNetBundle:AgancyWorkShcedule', 'ags')
                ->leftjoin('LaNetLaNetBundle:WorkShcedule', 's',  'WITH', 'ags.shcedule = s.id')
                ->where('ags.agancy = :agancy')
                ->setParameter('agancy', $agancy)
            ;
        
        $checkedShcedule = $queryBuilder->getQuery()->getResult();
        
        $checked = array();
        foreach($checkedShcedule as $value) {
            $checked[$value['name']] = array('start' => $value['startTime'], 'end' => $value['endTime']);
        }
        foreach($shcedule as $value) {
            $shceduleTemp = new LaEntity\AgancyWorkShcedule();
            $agancyShcedule[] = $shceduleTemp->setAgancy($agancy)->setShcedule($value);
        }
        
        if ('POST' == $request->getMethod()) {
            $queryBuilder
                    ->delete('LaNetLaNetBundle:AgancyWorkShcedule', 'ss')
                    ->where('ss.agancy = :agancy')->setParameter('agancy', $agancy)->getQuery()->execute();
            
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
         $session = $this->getRequest()->getSession();
      $salons = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findFilteredSalons($this->paginator, 10, $session->get('region'));
      $masterCategory = $this->manager->getRepository('LaNetLaNetBundle:MasterCategory')->findAll();

      return $this->render('LaNetLaNetBundle:Salon:salonList.html.twig', array('salons' => $salons, 
                                                                                 'masterCategory' => $masterCategory, 
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
