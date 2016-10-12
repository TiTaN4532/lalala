<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;
use Symfony\Component\Form\FormError;

class ProductCategoryController extends BaseController
{
    public function listAction(Request $request) {
      
        $categories = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->findBy(array('parent' => NULL));
        
        return $this->render('LaNetAdminBundle:ProductCategory:list.html.twig', array('categories' => $categories));
    }

    public function editAction(Request $request, $id = null)
    {
          $brandList = '';
          $brandId = '';
        if($id) {
          $category = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->find($id);
          $masterCategory = $category->getMasterCategory();
         
          $brandList = $this->manager->getRepository('LaNetLaNetBundle:Brand')->getBrandList($masterCategory->getId());
          $brandId = $category->getBrand();
          $brandId = $brandId->getId();
          
          if (!$category) {
            throw $this->createNotFoundException('Category not found!');
          }
        } else {
          $category = new LaEntity\ProductCategory();
          }
        
        
        $form = $this->createForm(new LaForm\ProductCategoryType(), $category);
        
        if ('POST' == $request->getMethod()) {
          
          $form->bind($request);
          
          if ($form->isValid()) {
              
          $brand = $request->get('brand') ? $this->manager->getRepository('LaNetLaNetBundle:Brand')->find($request->get('brand')) : ""; 
                   
           $category->setBrand($brand);
           $this->manager->persist($category);
           $this->get('session')->getFlashBag()->add(
                 'notice_product_category',
                  'Ваши изменения были сохранены'
             );
            try{
              $this->manager->flush();
            }
             catch (\Exception $e) {
                $form->addError(new FormError("Probably there are products related to some of deleted categories"));
            }
             return $this->redirect($this->generateUrl('la_net_admin_product_category_list'));
          }
        }

          return $this->render('LaNetAdminBundle:ProductCategory:edit.html.twig', array('form' => $form->createView(), 'brandList' => $brandList, 'brandId' => $brandId));

      }
      
    public function deleteAction(Request $request, $id)
    {
      $category = $this->manager->getRepository("LaNetLaNetBundle:ProductCategory")->findOneById($id);
      if (!$category)
        return new JsonResponse( 1 );

      $this->manager->remove($category);
      $this->manager->flush();
      $response['success'] = true;
      return new JsonResponse( $response );
    }

    
}
