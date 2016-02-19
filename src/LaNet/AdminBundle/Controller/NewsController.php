<?php

namespace LaNet\AdminBundle\Controller;

use LaNet\AdminBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\AdminBundle\Form\Type as LaForm;

class NewsController extends BaseController
{
    public function postsListAction(Request $request)
    {
        $newsPosts = $this->manager->getRepository('LaNetLaNetBundle:News')
                ->findAll();
        $pagination = $this->paginator->paginate(
            $newsPosts, $this->getRequest()->query->get('page', 1), 12
        );

        return $this->render('LaNetAdminBundle:News:List.html.twig', array('pagination' => $pagination));
    }

    public function editAction(Request $request, $id = null)
    {

      $newsRepo = $this->manager->getRepository('LaNetLaNetBundle:News');
      if (is_null($id)) {
        $newsPost = new LaEntity\News();
      } else {
        $newsPost = $newsRepo->find($id);
        if (!$newsPost) {
          throw $this->createNotFoundException('News post not found!');
        }
      }
      $form = $this->createForm(new LaForm\NewsPostsType(), $newsPost);

      if ('POST' == $request->getMethod()) {

        $form->bind($request);

        if ($form->isValid()) {
          if ($form->get('save_draft')->isClicked()) {
              $newsPost->setIsDraft(1);
          }
          $this->manager->persist($newsPost);
          $this->get('session')->getFlashBag()->add(
                'notice_news',
                'Ваши изменения были сохранены'
            );
          if(!$newsPost->getId()) {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_news_post_edit', array( 'id' => $newsPost->getId())));
          } else {
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_admin_news_posts'));
          }
        }
      }

        return $this->render('LaNetAdminBundle:News:Edit.html.twig', array('news_post' => $newsPost, 'form' => $form->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
      $newsPost = $this->manager->getRepository("LaNetLaNetBundle:News")->findOneById($id);
      if (!$newsPost)
        return new JsonResponse( 1 );

      $this->manager->remove($newsPost);
      $this->manager->flush();
      $response['success'] = true;
      return new JsonResponse( $response );
    }

    public function removeImageAction(Request $request, $id) 
    {
      $newsPost = $this->manager->getRepository('LaNetLaNetBundle:News')->find($id);
      unlink($newsPost->getAbsolutePath());
      $newsPost->setImage(null);
      $this->manager->flush();
      return new JsonResponse( 1 );
    }
}
