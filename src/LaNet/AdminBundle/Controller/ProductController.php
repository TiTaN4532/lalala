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
      if (is_null($id)) {
        $product = new LaEntity\Product();
      } else {
        $product = $productRepo->find($id);
        if (!$product) {
          throw $this->createNotFoundException('News post not found!');
        }
      }
      $form = $this->createForm(new LaForm\ProductType(), $product);

      if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {
         
          $this->manager->persist($product);
          $this->get('session')->getFlashBag()->add(
                'notice_product',
                'Ваши изменения были сохранены'
            );
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_product_list'));
        }
      }

        return $this->render('LaNetAdminBundle:Product:Edit.html.twig', array('menuPoint' => 'product', 'product' => $product, 'form' => $form->createView()));
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
}
