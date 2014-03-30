<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class SalonController extends BaseController
{
  
  public function mainAction(Request $request)
  {
    return $this->render('LaNetAdminBundle:Salon:main.html.twig', array('menuPoint' => 'salons'));
  }

  
  public function listAction(Request $request)
    {
        $usersFilter = array("#" => "", "0-9" => "", "A" => "a", "B" => "b", "C" => "c", "D" => "d", "E" => "e", "F" => "f", "G" => "g", "H" => "h",
                             "I" => "i", "J" => "j", "K" => "k", "L" => "l", "M" => "m", "N" => "n", "O" => "o", "P" => "p", "Q" => "q",
                              "R" => "r", "S" => "s", "T" => "t", "U" => "u", "V" => "v", "W" => "w", "X" => "x", "Y" => "y", "Z" => "z");
        return $this->render('LaNetAdminBundle:Salon:list.html.twig', array('menuPoint' => 'salons', 'usersFilter' => $usersFilter));
    }
    
    public function listAjaxAction(Request $request)
    {
        $page = $request->query->get('page', 1);
        $filter = $request->get('filter') ? $request->get('filter') : '';
        
        $query = $this->manager->getRepository("LaNetLaNetBundle:User")->createQueryBuilder('u')
                ->select('u')
                ->where("u.roles LIKE '%ROLE_SALON%'");

        $result = $query->getQuery();
       
        $paginator = $this->paginator->paginate($result, $page, 10);
        $paginator->setTemplate('LaNetLaNetBundle:Pagination:ajaxPager.html.twig');
        $paginator->setUsedRoute('la_net_admin_profiles_ajax');
        $paginator->setParam('filter', $filter);
        $paginator->setCustomParameters(array(
            'divId' => 'users-list'
        ));

        return $this->render('LaNetAdminBundle:Salon:listAjax.html.twig', array('items' => $paginator));
    }
    
       
    public function deleteAction(Request $request, $id)
    {
        $user = $this->manager->getRepository('LaNetLaNetBundle:User')->find($id);

        $this->manager->remove($user);
        
        $this->manager->flush();

        return new JsonResponse(1);
    }
    
    public function listCategoryAction(Request $request)
    {
      $categories = $this->manager->getRepository("LaNetLaNetBundle:SalonCategory")->findAll();

      $category = new LaEntity\SalonCategory();

      $form = $this->createForm(new LaForm\SalonCategoryType(), $category);
      return $this->render('LaNetAdminBundle:Salon:Category.html.twig', array('menuPoint' => 'salons', 'categories' => $categories, 'form' => $form->createView()));
    }

    public function newCategoryAction(Request $request)
    {
      $form = $this->createForm(new LaForm\SalonCategoryType());
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
