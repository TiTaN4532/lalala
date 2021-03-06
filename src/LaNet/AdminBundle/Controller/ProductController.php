<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class ProductController extends BaseController
{
    public function ListAction(Request $request)
    {
        $products = $this->manager->getRepository('LaNetLaNetBundle:Product')
                ->findBy(array(), array('id' => 'DESC'));
        $pagination = $this->paginator->paginate(
            $products, $this->getRequest()->query->get('page', 1), 12
        );

        return $this->render('LaNetAdminBundle:Product:List.html.twig', array('menuPoint' => 'product', 'pagination' => $pagination));
    }

    public function editAction(Request $request, $id = null)
    {

      $productRepo = $this->manager->getRepository('LaNetLaNetBundle:Product');
      $categories = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->findBy(array('parent' => null));
      $categoryTree = array();
      if (is_null($id)) {
        $product = new LaEntity\Product();
        if($this->session->has('product_category')) {
          $category = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->find($this->session->get('product_category'));
          $product->setCategory($category);
          $categoryTree[] = $parentCategory = $product->getCategory();
            while($parentCategory->getParent() != null) {
              $categoryTree[] = $parentCategory = $parentCategory->getParent();
            }
            $categoryTree = array_reverse($categoryTree);
        }
      } else {
        $product = $productRepo->find($id);
        if (!$product) {
          throw $this->createNotFoundException('News post not found!');
        }
        
        $categoryTree[] = $parentCategory = $product->getCategory();
        while($parentCategory->getParent() != null) {
          $categoryTree[] = $parentCategory = $parentCategory->getParent();
        }
        $categoryTree = array_reverse($categoryTree);
      }
      $form = $this->createForm(new LaForm\ProductType(), $product);

      if ('POST' == $request->getMethod()) {

        $form->bind($request);
        if ($form->isValid()) {
          $category = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->find($request->get('category'));
          if($request->request->has('descr-items'))
          {
              foreach($request->get('descr-items') as $key => $value) {
                  $item = $this->manager->getRepository('LaNetLaNetBundle:ProductCategoryDescriptionItem')->find($key);
                  if($itemName = $product->hasDescriptionItem($item)) {
                      $itemName->setName($value);
                      $this->manager->persist($itemName);
                  } else {
                      $itemName = new LaEntity\ProductCategoryDescriptionName();
                      $itemName->setName($value);
                      $itemName->setDescriptionItem($item);
                      $itemName->setProduct($product);
                      $this->manager->persist($itemName);
                      $product->addDescriptionName($itemName);
                  } 
              }
          }
          $product->setCategory($category);
          $this->manager->persist($product);
          $this->session->set('product_category', $category->getId());
          $this->session->getFlashBag()->add(
                'notice_product',
                'Ваши изменения были сохранены'
            );
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_product_list'));
        }
        else {
          print_r($form->getErrorsAsString());
        }
      }

        return $this->render('LaNetAdminBundle:Product:Edit.html.twig', array('menuPoint' => 'product',
                                                                              'product' => $product, 
                                                                              'categoryTree' => $categoryTree, 
                                                                              'categories' => $categories, 
                                                                              'form' => $form->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
      $product = $this->manager->getRepository("LaNetLaNetBundle:Product")->findOneById($id);
      if (!$product)
        return new JsonResponse( 1 );

      $this->manager->remove($product);
      $this->manager->flush();
      $response['success'] = true;
      return new JsonResponse( $response );
    }

    public function removeImageAction(Request $request, $id) 
    {
      $product = $this->manager->getRepository('LaNetLaNetBundle:Product')->find($id);
      unlink($product->getAbsolutePath());
      $product->setImage(null);
      $this->manager->flush();
      return new JsonResponse( 1 );
    }
    
    public function ajaxSelectCategoryAction(Request $request, $id) 
    {
      $response = array();
      $data = array();
      $descrItems = array();
      $category = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->find($id);
      if($category->getChildren()->count()) {
          $response['has_children'] = 1;
          foreach($category->getChildren() as $value) {
            $data[] = array('id' => $value->getId(), 'name' => $value->getName());
          }
          $response['data'] = $data;
      }
      else {
          $response['has_children'] = 0;
      }
      if($category->getDescriptionItem()->count()) {
          $response['has_description'] = 1;
          foreach($category->getDescriptionItem() as $value) {
            $descrItems[] = array('id' => $value->getId(), 'name' => $value->getName());
          }
          $response['items'] = $descrItems;
      } else {
          $response['has_description'] = 0;
      }
      return new JsonResponse( $response );
    }
    
    
}
