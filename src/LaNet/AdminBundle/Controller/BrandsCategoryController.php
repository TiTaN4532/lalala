<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class BrandsCategoryController extends BaseController
{
    public function listAction(Request $request)
    {
      $categories = $this->manager->getRepository("LaNetLaNetBundle:BrandsCategory")->findAll();
       $pagination = $this->paginator->paginate(
            $categories, $this->getRequest()->query->get('page', 1), 12);
      
      return $this->render('LaNetAdminBundle:Brand:Category.html.twig', array('pagination' => $pagination));
    }

    /*public function newCategoryAction(Request $request)
    {
      $form = $this->createForm(new LaForm\BrandsCategoryType());
      if ('POST' == $request->getMethod())
      {
        $form->bind($request);
        if ($form->isValid())
        {
          $data = $form->getData();
          $this->manager->persist($data);
          $this->manager->flush();
          $response['success'] = true;
          $response['msg'] = 'Категория успешно создана';
          $response['id'] = $data->getId();
          $response['name'] = $data->getName();

        }else{
          $response['success'] = false;
          $response['msg'] = preg_replace('/.*ERROR:/', '', str_replace("\n",'', $form->getErrorsAsString()));
        }

        return new JsonResponse( $response );
      }
    }*/

    public function editAction(Request $request, $id = null)
    {

      $brandsRepo = $this->manager->getRepository('LaNetLaNetBundle:BrandsCategory');
     
      if (is_null($id)) {
        $BrandsPost = new LaEntity\BrandsCategory();
        
      } else {
        $BrandsPost = $brandsRepo->find($id);
        if (!$BrandsPost) {
          throw $this->createNotFoundException('not found!');
        }
      }
      
      $form = $this->createForm(new LaForm\BrandsCategoryType(), $BrandsPost);
    
        if ('POST' == $request->getMethod()) {
            $form->bind($request);

        if ($form->isValid()) {
           if ($form->get('save')->isClicked()) {
            $this->get('session')->getFlashBag()->add(
                'notice_brandsCategory',
                'Ваши изменения были сохранены'
            );
         
          $this->manager->persist($BrandsPost);
          $this->manager->flush();
          }
          return $this->redirect($this->generateUrl('la_net_admin_brands_categories_list'));
        }
      }

        return $this->render('LaNetAdminBundle:Brand:editCategory.html.twig', array('brand' => $BrandsPost, 'form' => $form->createView()));
    }
    
    
    public function deleteCategoryAction(Request $request, $id)
    {
      $category = $this->manager->getRepository("LaNetLaNetBundle:BrandsCategory")->findOneById($id);
      if (!$category)
        return new JsonResponse( 1 );
  //    if (!$category->getProjects()->isEmpty()) {
  //      foreach($category->getProjects() as $value)
  //      {
  //        $value->setCategory(null);
  //        $value->setIsDeleted(1);
  //        $value->setDeleted(new \DateTime());
  //        $this->manager->persist($value);
  //      }
  //    }
  //    $this->manager->remove($category);
  //    $this->manager->flush();
  //    $response['success'] = true;
  //    $response['msg'] = 'The category is removed successfully';
      if ($category->getBrand()->isEmpty()) {
        $this->manager->remove($category);
        $this->manager->flush();
        $response['success'] = true;
        $response['msg'] = 'Категория успешно удалена.';
      }
      else {
        $response['success'] = false;
        $response['msg'] = 'Есть бренды, которые относятся к этой категории.';
      }
      return new JsonResponse( $response );
    }
    
    
     public function removeImageAction(Request $request, $id) 
    {
      $advicesPost = $this->manager->getRepository('LaNetLaNetBundle:BrandsCategory')->find($id);
      unlink($advicesPost->getAbsolutePath());
      $advicesPost->setImage(null);
      $this->manager->flush();
      return new JsonResponse( 1 );
    }
}
