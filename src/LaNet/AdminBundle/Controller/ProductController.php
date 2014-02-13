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
                ->findAll();
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
          $product->setCategory($category);
          $this->manager->persist($product);
          $this->get('session')->getFlashBag()->add(
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

        return $this->render('LaNetAdminBundle:Product:Edit.html.twig', array('menuPoint' => 'product', 'product' => $product, 'categoryTree' => $categoryTree, 'categories' => $categories, 'form' => $form->createView()));
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
      return new JsonResponse( $response );
    }
    
    
}
