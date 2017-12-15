<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;

class DiscountsController extends BaseController
{
    public function mainAction()
    {
        return $this->render('LaNetAdminBundle:Discounts:main.html.twig');
    }
    
    public function listAction(Request $request)
    {
            $discount = $this->manager->getRepository('LaNetLaNetBundle:Discounts')
                ->findBy(array(), array('inTop' => 'DESC', 'created' => 'DESC'));
        
            
            $pagination = $this->paginator->paginate(
            $discount, $this->getRequest()->query->get('page', 1), 12
        );

        return $this->render('LaNetAdminBundle:Discounts:List.html.twig', array('pagination' => $pagination));
    }
    
    
   public function editAction(Request $request, $id = null)
    {
      $discountRepo = $this->manager->getRepository('LaNetLaNetBundle:Discounts');
      $salonCategory = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findAll();
     
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
            
            $salon = $this->manager->getRepository('LaNetLaNetBundle:Salon')->findOneById($request->get('salonCategory'));
            $discount->setSalon($salon);
            
            $this->manager->persist($discount);
          
          
           $this->manager->flush();
           return $this->redirect($this->generateUrl('la_net_admin_discounts_list'));
        }
      }

        return $this->render('LaNetAdminBundle:Discounts:Edit.html.twig', array('discount' => $discount, 'salonCategory' => $salonCategory, 'form' => $form->createView()));
    }
    
    public function listBySalonAction(Request $request)
    {
            $salons = $this->manager->getRepository('LaNetLaNetBundle:Salon')
                ->findDiscountsBySalon();
            
                   
        return $this->render('LaNetAdminBundle:Discounts:ListBySalon.html.twig', array('salons' => $salons));
    }
    
    public function listByOneSalonAction(Request $request, $id)
    {
            $discounts = $this->manager->getRepository('LaNetLaNetBundle:Salon')
                ->findDiscountsByOneSalon($id);
            $pagination = $this->paginator->paginate(
            $discounts, $this->getRequest()->query->get('page', 1), 12
         );    
            
        return $this->render('LaNetAdminBundle:Discounts:ListByOneSalon.html.twig', array('pagination' => $pagination));
    }

    
    public function deleteAction(Request $request, $id)
    {
      $advicesPost = $this->manager->getRepository("LaNetLaNetBundle:Articles")->findOneById($id);
      if (!$advicesPost)
        return new JsonResponse( 1 );

      $this->manager->remove($advicesPost);
      $this->manager->flush();
      $response['success'] = true;
      return new JsonResponse( $response );
    }
   
     public function inTopAction(Request $request, $id)
    {
        $discount = $this->manager->getRepository('LaNetLaNetBundle:Discounts')->find($id);
       
       if ($discount-> getinTop() == NULL){
           $discount-> setInTop(new \DateTime());
        }
         else{
            $discount-> setInTop();
         }
      
        $this->manager->persist($discount);
        $this->manager->flush();

        return new JsonResponse(1);
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
    
}
