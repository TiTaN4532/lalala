<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class BrandController extends BaseController
{
    public function listAction(Request $request)
    {
        $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')
                ->findAll();
        $pagination = $this->paginator->paginate(
            $brands, $this->getRequest()->query->get('page', 1), 1000
        );

        return $this->render('LaNetAdminBundle:Brand:list.html.twig', array('pagination' => $pagination));
    }

    public function editAction(Request $request, $id = null)
    {

      $newsRepo = $this->manager->getRepository('LaNetLaNetBundle:Brand');
      if (is_null($id)) {
        $brand = new LaEntity\Brand();
      } else {
        $brand = $newsRepo->find($id);
        if (!$brand) {
          throw $this->createNotFoundException('Brand not found!');
        }
      }
      $form = $this->createForm(new LaForm\BrandType(), $brand);

      if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {
          $this->manager->persist($brand);
          $this->get('session')->getFlashBag()->add(
                'notice_brand',
                'Ваши изменения были сохранены'
            );
          
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_brand_list'));
        }
      }

        return $this->render('LaNetAdminBundle:Brand:edit.html.twig', array('brand' => $brand, 'form' => $form->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
      $brand = $this->manager->getRepository("LaNetLaNetBundle:Brand")->findOneById($id);
      if (!$brand)
        return new JsonResponse( 1 );
      if($brand->getProduct()->isEmpty()) {
        $this->manager->remove($brand);
        $this->manager->flush();
        $response['success'] = true;
      } else {
        $response['success'] = false;
      }
      return new JsonResponse( $response );
    }

    public function removeImageAction(Request $request, $id) 
    {
      $brand = $this->manager->getRepository('LaNetLaNetBundle:Brand')->find($id);
      unlink($brand->getAbsolutePath());
      $newsPost->setImage(null);
      $this->manager->flush();
      return new JsonResponse( 1 );
    }
}
