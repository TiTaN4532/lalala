<?php

namespace LaNet\LaNetBundle\Controller;

use LaNet\LaNetBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LaNet\LaNetBundle\Entity as LaEntity;
use LaNet\LaNetBundle\Form\Type as LaForm;
use LaNet\AdminBundle\Form\Type as LaFormAdm;


class BrandController extends BaseController
{
    public function brandListAction(Request $request)
    {
                
        $testsSlider = $this->manager->getRepository('LaNetLaNetBundle:Articles')->findListArticlesOnMainPage('test');
        //$brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findListBrandByMasterCat($request->get('name'), $request->get('category'));
        $brands = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findListBrandByBrandsCat(($request->get('category')) ? $request->get('category'):false, ($request->get('name')) ? $request->get('name'):false);
       
        $pagination = $this->paginator->paginate(
             $brands, $this->getRequest()->query->get('page', 1), 10);

        $SiteSettings = $this->manager->getRepository('LaNetLaNetBundle:SiteSettings')->findBy(array('name' => 'LaLook'));
        //$masterCategory = $this->manager->getRepository('LaNetLaNetBundle:MasterCategory')->findAll();
        $brandsCategory = $this->manager->getRepository('LaNetLaNetBundle:BrandsCategory')->findAll();
        
        $brandPost = new LaEntity\Brand();
        $brandForm = $this->createForm(new LaForm\BrandType(), $brandPost);
        
        if ('POST' == $request->getMethod()) {

         $brandForm->bind($request);
         
          $newPass =$this->generate_password (10);
         
          $succesfullyRegistered = $this->register($brandForm->getData()->getMail(), $brandForm->getData()->getName(), $newPass, $brandPost);

         if ( $brandForm->isValid() && $succesfullyRegistered) {
             
              $uniqId = uniqid();
              $brandPost->setIsDraft(1);
              $brandPost->setModeration(1);
              $brandPost->setValidation($uniqId);
                           
              $this->manager->persist($brandPost);
              $data = ($brandForm->getData());
              $mail = $data->getMail();
              $message = \Swift_Message::newInstance()
                     ->setSubject('Подтверждение регистрации бренда')
                     //->setSubject($data['subject'])
                     ->setFrom('info@lalook.net')
                     ->setTo($data->getMail())
                     ->setBody("Здравствуйте!
                     Вы зарегестрировали бренд на сайте http://lalook.net

                     Ваш пароль: $newPass
                     Ваш логин: $mail

                     Для завершения регистрации перейдите по ссылке ниже
                     http://lalook.net/brands/validation/$uniqId

                     Вход в личный кабинет http://lalook.net/login
                      ");
                         //$this->renderView('LaNetAdminBundle:Sendmail:validation.html.twig', array('uniqId' => $uniqId)), 'text/html');

               
               
              //return $this->render('LaNetAdminBundle:Sendmail:validation.html.twig', array('uniqId' => $uniqId));  
               
              $this->get('mailer')->send($message);
              $this->get('session')->getFlashBag()->add(
                    'notice_brand_main',
                    ' На указанную вами почту выслано письмо с подтверждением регистрации. Для активации нужно перейти по ссылке указаной в письме.
                     Обратите внимание: письмо может попасть в папку "Спам", рекомендуем обязательно её проверить.'             
                      );
              $this->manager->flush();
            
            return $this->redirect($this->generateUrl('la_net_la_net_brands_list'));               
             
             
            }
            
             else {
            
             return $this->render('LaNetLaNetBundle:Brand:brandList.html.twig', array('brands' => $pagination,
                                                                                 'SiteSettings' => $SiteSettings,
                                                                                 'testsSlider' => $testsSlider,
                                                                                 'masterCategory' => $brandsCategory,
                                                                                 'error' => true,
                                                                                 'form' => $brandForm->createView()));                        

             }
            
            
            
            
            }
        
        return $this->render('LaNetLaNetBundle:Brand:brandList.html.twig', array('brands' => $pagination,
                                                                                 'SiteSettings' => $SiteSettings,
                                                                                 'testsSlider' => $testsSlider,
                                                                                 'masterCategory' => $brandsCategory,
                                                                                 'form' => $brandForm->createView()));
    }
    
    public function brandIdAction(Request $request, $slug)
    {
       $brand = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findOneBy(array('slug' => $slug));
       $id = $brand->getId();
       $idCookie = "b_".$id;
       $voteDisable = false;
       $cookies = $request->cookies;

       if ($cookies->has('myCookie2')){
           if (!empty ($cookies->get('myCookie2'))){
                $cookieMaster = $cookies->get('myCookie2');
                $cookieArr = explode(";",  $cookieMaster);
                    foreach ($cookieArr as $value) {
                        if ($value == $idCookie) $voteDisable = true;
                    }
            }
      } 
        
        return $this->render('LaNetLaNetBundle:Brand:brandId.html.twig', array('brand' => $brand, 'voteDisable' => $voteDisable));
    }
    
    public function validationAction($uniqId)
    {   
        $brand = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findOneBy(array('validation' => $uniqId));
        $validStatus = ' ';
            if (!is_null($brand)){
                $brand->setValidation(1);
                $this->manager->persist($brand);

                $this->manager->flush();
                $validStatus = true;
            }

            else{
                  $validStatus = false;      
            }
        
        return $this->render('LaNetLaNetBundle:Brand:valid.html.twig', array('validStatus' => $validStatus));
    
    }
    
    private function register($email,$username,$password, $brandPost){    
      $userManager = $this->get('fos_user.user_manager');

      // Or you can use the doctrine entity manager if you want instead the fosuser manager
      // to find 
      //$em = $this->getDoctrine()->getManager();
      //$usersRepository = $em->getRepository("mybundleuserBundle:User");
      // or use directly the namespace and the name of the class 
      // $usersRepository = $em->getRepository("mybundle\userBundle\Entity\User");
      //$email_exist = $usersRepository->findOneBy(array('email' => $email));
      
      $email_exist = $userManager->findUserByEmail($email);

            // Check if the user exists to prevent Integrity constraint violation error in the insertion
      if($email_exist){
          return false;
      }

      $user = $userManager->createUser();
      $user->setUsername($username);
      $user->setUserInfo($brandPost);
      $user->setEmail($email);
      $user->setEmailCanonical($email);
      $user->addRole('ROLE_BRAND');
      $user->setLocked(0); // don't lock the user
      $user->setEnabled(1); // enable the user or enable it later with a confirmation token in the email
      // this method will encrypt the password with the default settings :)
      $user->setPlainPassword($password);
      $userManager->updateUser($user);

      return true;
   }
    
    function generate_password($number)

    {
   
    $arr = array('a','b','c','d','e','f',

    'g','h','i','j','k','l',

    'm','n','o','p','r','s',

    't','u','v','x','y','z',

    'A','B','C','D','E','F',

    'G','H','I','J','K','L',

    'M','N','O','P','R','S',

    'T','U','V','X','Y','Z',

    '1','2','3','4','5','6',

    '7','8','9','0');

    // Генерируем пароль

    $pass = "";

    for($i = 0; $i < $number; $i++)

    {

    // Вычисляем случайный индекс массива

    $index = rand(0, count($arr) - 1);

    $pass .= $arr[$index];

    }

    return $pass;

    }
    
    public function profileAction(Request $request)
    {
       
        if ($this->user){
        $premium = $this->user->getPremium();
        }else{
           return $this->redirect($this->generateUrl('la_net_la_net_homepage'));
        }
       
        $form = $this->createForm(new LaForm\BrandProfileType(), $this->user);

               
        if ('POST' == $request->getMethod()) {
        /*if($prevLocation = $this->user->getUserInfo()->getLocation()) {
            $this->manager->remove($prevLocation);
            $this->manager->flush();
        }*/

        $form->bind($request);

        if ($form->isValid()) {
          $this->user->getBrandInfo()->setModeration(1);  
          $this->manager->persist($this->user);
          $this->get('session')->getFlashBag()->add(
                'notice_profile',
                'Ваши изменения были сохранены. В ближайшее время их проверит модератор'
            );
          $this->manager->flush();

            return $this->redirect($this->generateUrl('la_net_la_net_brands_profile'));
        }
      }
      
        return $this->render('LaNetLaNetBundle:Brand:profile.html.twig', array('premium' => $premium, 'form' => $form->createView()));
    }
    
    public function listCategoryProfileAction(Request $request) {
      
        if ($this->user){
        $premium = $this->user->getPremium();
        }else{
           return $this->redirect($this->generateUrl('la_net_la_net_homepage'));
        }
        $brandId = $this->user->getBrandInfo()->getId();
        
        $categories = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->findBy(array('parent' => NULL, 'brand' => $brandId));
        
        return $this->render('LaNetLaNetBundle:Brand:listCategoryProfile.html.twig', array('categories' => $categories, 'premium' => $premium));
    }
    
     public function editCategoryProfileAction(Request $request, $id = null)
    {
          $brandId = $this->user->getBrandInfo()->getId();
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
        
        
        $form = $this->createForm(new LaFormAdm\ProductCategoryType(), $category);
        
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
             return $this->redirect($this->generateUrl('la_net_la_net_brands_profile_product_category'));
          }
        }

          return $this->render('LaNetLaNetBundle:Brand:editCategoryProfile.html.twig', array('brand' => $brand,  'form' => $form->createView()));

      }
      
    public function deleteCategoryProfileAction(Request $request, $id)
    {
      $category = $this->manager->getRepository("LaNetLaNetBundle:ProductCategory")->findOneById($id);
      if (!$category)
        return new JsonResponse( 1 );

      $this->manager->remove($category);
      $this->manager->flush();
      $response['success'] = true;
      return new JsonResponse( $response );
    }
    
    
     public function listProductsProfileAction(Request $request)
    {
        $premium = $this->user->getPremium();
       
        /*$brandId = $this->user->getBrandInfo()->getId();
         
        $brandCategory = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findBrandCategoryByBrand ($brandId);
        
        $brand = $this->manager->getRepository('LaNetLaNetBundle:Brand')->find($brandId);
        
         
        $product_cat = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->getProductsCategoryOnBrand($brandId);
        
        $product_sub_cat = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->getProductsSubCategory();
                
        $products = $this->manager->getRepository('LaNetLaNetBundle:Product')->findFilteredProducts(false, 1, $brandId);
        
        $id_product_sub_cat = ($request->get('product_sub_cat')); 
        $id_product_sub_cat_array = $this->manager->getRepository('LaNetLaNetBundle:Product')->getArrayCatId($id_product_sub_cat);
               
        $selectedCategories = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->getParentId(($request->get('product_sub_cat')) ? $request->get('product_sub_cat') : "");
        
        if ( $selectedCategories)
        {
        $selectedCategories = array_reverse($selectedCategories, true);
         
        }
         */
        $brandId = $this->user->getBrandInfo()->getId();
        $products = $this->manager->getRepository('LaNetLaNetBundle:Product')->findFilteredProductsByBrand($brandId);
        /*print_r ($products[0]->getId());
        exit();*/
         /* $products = $this->manager->getRepository('LaNetLaNetBundle:Product')
                ->findBy(array('brand' => $brandId), array('id' => 'DESC'));*/
        $pagination = $this->paginator->paginate(
            $products, $this->getRequest()->query->get('page', 1), 12
        );

         
        return $this->render('LaNetLaNetBundle:Brand:listProductsProfile.html.twig', array('pagination' => $pagination, 'premium' => $premium));
    }

    public function editProductsProfileAction(Request $request, $id = null)
    {
      $brandId = $this->user->getBrandInfo()->getId();
      $productRepo = $this->manager->getRepository('LaNetLaNetBundle:Product');
      $categories = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->findBy(array('parent' => NULL, 'brand' => $brandId));
      $brandCategory = $this->manager->getRepository('LaNetLaNetBundle:Brand')->findBrandCategoryByBrand ($brandId);
      $brand = $this->manager->getRepository('LaNetLaNetBundle:Brand')->find($brandId);
      $categoryTree = array();
      
      if (is_null($id)) {
        $product = new LaEntity\Product();
         /* if($this->session->has('master_category')) {
          $brandList = $this->manager->getRepository('LaNetLaNetBundle:Brand')->getBrandList ($this->session->get('master_category'));    
         
          if($this->session->has('brand')) {
          
          if($this->session->has('product_category')) {
          $category = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->find($this->session->get('product_category'));
          $product->setCategory($category);
          print_r ($this->session->get('product_category'));
          $categories = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->findBy(array('masterCategory' => $this->session->get('master_category'), 'brand' => $this->session->get('brand')));
          $parentCategory = $product->getCategory();
          $categoryTree[] = $parentCategory = $product->getCategory();
            while($parentCategory->getParent() != null) {
              $categoryTree[] = $parentCategory = $parentCategory->getParent();
            }
            $categoryTree = array_reverse($categoryTree);
           }
        }
          
          
          }
          */
      } else {
        $product = $productRepo->find($id);
        if (!$product) {
          throw $this->createNotFoundException('post not found!');
        }
        
        $MasterCategory = $product->getBrandsCategory();
              
        $categories = $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->findBy(array('brand' => $product->getBrand()));
        //$brandList = $this->manager->getRepository('LaNetLaNetBundle:Brand')->getBrandList ($MasterCategory->getId());
        $categoryTree[] = $parentCategory = $product->getCategory();
       
        while($parentCategory->getParent() != null) {
          $categoryTree[] = $parentCategory = $parentCategory->getParent();
        }
        $categoryTree = array_reverse($categoryTree);
      }
            
      $form = $this->createForm(new LaFormAdm\ProductType(), $product);

      if ('POST' == $request->getMethod()) {

        $form->bind($request);
        if ($form->isValid()) {
          
          $category = $request->get('category') ? $this->manager->getRepository('LaNetLaNetBundle:ProductCategory')->find($request->get('category')) : ""; 
          $brandCategory_session = $request->get('brandCategory') ? $this->manager->getRepository('LaNetLaNetBundle:BrandsCategory')->find($request->get('brandCategory')) : ""; 
          $brand = $request->get('brand') ? $this->manager->getRepository('LaNetLaNetBundle:Brand')->find($request->get('brand')) : ""; 
              
        if ((empty($brandCategory_session)) or (empty($brand)) or (empty($category))) {
              
              $this->session->getFlashBag()->add(
                'notice_product_fail',
                'Товар не добавлен. Форма заполнена не полностью!'
            );
            $this->manager->flush(); 
        }
               
        else {
                  
          /*if($request->request->has('descr-items'))
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
          }*/
         
          $product->setBrandsCategory($brandCategory_session);
          $product->setBrand($brand);
          $product->setCategory($category);
          $this->manager->persist($product);
          
          /*$this->session->set('brand_category', $brandCategory_session->getId());
          $this->session->set('product_category', $category->getId());
          $this->session->set('brand', $brand->getId());
           */
          $this->session->getFlashBag()->add(
                'notice_product',
                'Ваши изменения были сохранены'
            );
            $this->manager->flush();
            return $this->redirect($this->generateUrl('la_net_la_net_brands_profile_products'));
        }
       /*else {
          print_r($form->getErrorsAsString());
      }*/
      }}

        return $this->render('LaNetLaNetBundle:Brand:editProductsProfile.html.twig', array('product' => $product, 
                                                                              'categoryTree' => $categoryTree, 
                                                                              'categories' => $categories,
                                                                              'brand' => $brand,
                                                                              'brandCategory' => $brandCategory,
                                                                              'form' => $form->createView()));
    }

    public function deleteProductsProfileAction(Request $request, $id)
    {
      $product = $this->manager->getRepository("LaNetLaNetBundle:Product")->findOneById($id);
      if (!$product)
        return new JsonResponse( 1 );

      $this->manager->remove($product);
      $this->manager->flush();
      $response['success'] = true;
      return new JsonResponse( $response );
    }

    public function removeImageProductsProfileAction(Request $request, $id) 
    {
      $product = $this->manager->getRepository('LaNetLaNetBundle:Product')->find($id);
      unlink($product->getAbsolutePath());
      $product->setImage(null);
      $this->manager->flush();
      return new JsonResponse( 1 );
    }
    
    public function ajaxProductsProfileSelectCategoryAction(Request $request, $id) 
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
