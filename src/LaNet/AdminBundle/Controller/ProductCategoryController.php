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
    
   public function brandListAction(Request $request)
    {
        $name = $request->get('name');
            
        $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findListBrand($name); 
            $pagination = $this->paginator->paginate(
            $brands, $this->getRequest()->query->get('page', 1), 1000
        );

        return $this->render('LaNetAdminBundle:ProductCategory:BrandList.html.twig', array('pagination' => $pagination));
    }
    
    
    public function listAction(Request $request) {
      
        $id = $request->get('id_brand');
        
        $categories = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->findBy(array('parent' => NULL, 'brand' => $id));
        
        return $this->render('LaNetAdminBundle:ProductCategory:list.html.twig', array('categories' => $categories, 'brand' => $id));
    }

    public function editAction(Request $request, $id = null)
    {
          $brandId = $request->get('id_brand');
          //$brandCategory = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findBrandCategoryByBrand ($brandId);
          $brand = $this->manager->getRepository('LaNetLaNetBundle:Brand')->find($brandId);
         // $currentBrandCategory='';
          
          if($id) {
          $category = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->find($id);
          //$currentBrandCategory = $category->getBrandCategory()->getId();
          
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
           //$brandCategorySelected = $this->manager->getRepository('LaNetLaNetBundle:BrandsCategory')->find($request->get('brandsCategory'));
          
           $category->setBrand($brand);
          // $category->setBrandCategory($brandCategorySelected);
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
             return $this->redirect($this->generateUrl('la_net_admin_product_category_list', array('id_brand' => $brandId)));
          }
        }

          return $this->render('LaNetAdminBundle:ProductCategory:edit.html.twig', array('brand' => $brand,  'form' => $form->createView()));

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
