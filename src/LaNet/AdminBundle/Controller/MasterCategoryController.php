<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class MasterCategoryController extends BaseController
{
    public function listAction(Request $request)
    {
      $categories = $this->manager->getRepository("LaNetLaNetBundle:MasterCategory")->findAll();

      $category = new LaEntity\MasterCategory();

      $form = $this->createForm(new LaForm\MasterCategoryType(), $category);
      return $this->render('LaNetAdminBundle:Master:Category.html.twig', array('categories' => $categories, 'form' => $form->createView()));
    }

    public function newCategoryAction(Request $request)
    {
      $form = $this->createForm(new LaForm\MasterCategoryType());
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
    }

    public function deleteCategoryAction(Request $request, $id)
    {
      $category = $this->manager->getRepository("LaNetLaNetBundle:MasterCategory")->findOneById($id);
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
      if ($category->getMaster()->isEmpty()) {
        $this->manager->remove($category);
        $this->manager->flush();
        $response['success'] = true;
        $response['msg'] = 'Категория успешно удалена.';
      }
      else {
        $response['success'] = false;
        $response['msg'] = 'Есть мастера, которые относятся к этой категории.';
      }
      return new JsonResponse( $response );
    }
}
