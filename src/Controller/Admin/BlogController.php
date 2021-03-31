<?php

namespace App\Controller\Admin;


use App\Entity\Blog;
use App\Entity\BlogCategory;
use App\Entity\GeneralSetting;
use App\Entity\User;
use App\Repository\BlogRepository;
use App\Resolver\GeneralSettingResolver;
use Doctrine\Common\Collections\ArrayCollection;
use Entity\Category;
use App\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;

class BlogController extends AbstractController
{

    /**
     * @Route  ("/general-settings",  name ="general_settings", methods={"GET", "POST"})
     * @return Response
     */

    public function generalSettingsAction(Request $request)
    {
        $message = '';
       $cache = new FilesystemAdapter();

       /** @var CacheItem $settingsItem */
       $settingsItem = $cache->getItem('settings');
       $settings = $settingsItem->get();

       if ($settings === null) {

           $settingsItem->set($settings);
           $cache->save($settingsItem);
       }
        $em =$this->getDoctrine()->getManager();
        $settings = $em->getRepository(GeneralSetting::class)->findAll();
        $settingsResolver = new GeneralSettingResolver($settings);
        if($request->getMethod() === Request::METHOD_POST){
            $em->persist($this->getSetting($settingsResolver, 'site_url'));
            $em->persist($this->getSetting($settingsResolver, 'title'));
            $em->persist($this->getSetting($settingsResolver, 'description'));
            $em->persist($this->getSetting($settingsResolver, 'author'));
            $em->persist($this->getSetting($settingsResolver, 'keyword'));
            $em->flush();
        }
        return $this->render('admin/generalSetting.twig', [
            'settings' => $this->getSettings(),
            'message' => $message

        ]);
    }

    /**
     * @Route  ("/soc-settings",  name ="social_settings", methods={"GET", "POST"})
     * @return Response
     */
    public function socSettingAction(Request $request)
    {
        $message = '';
        $cache = new FilesystemAdapter();

        /** @var CacheItem $settingsItem */
        $settingsItem = $cache->getItem('settings');
        $settings = $settingsItem->get();

        if ($settings === null) {

            $settingsItem->set($settings);
            $cache->save($settingsItem);
        }
        $em =$this->getDoctrine()->getManager();
        $settings = $em->getRepository(GeneralSetting::class)->findAll();
        $settingsResolver = new GeneralSettingResolver($settings);
        if($request->getMethod() === Request::METHOD_POST){
            $em->persist($this->getSetting($settingsResolver, 'facebook'));
            $em->persist($this->getSetting($settingsResolver, 'twitter'));
            $em->persist($this->getSetting($settingsResolver, 'youtube'));
            $em->persist($this->getSetting($settingsResolver, 'linkedin'));
            $em->persist($this->getSetting($settingsResolver, 'instagram'));
            $em->flush();
        }
        return $this->render('admin/socialSetting.twig', [
            'settings' => $this->getSettings(),
            'message' => $message

        ]);
    }

    /**
     * @param GeneralSettingResolver $settingsResolver
     * @param Request $request
     * @param $key
     * @return GeneralSetting
     */
    public function getSetting(GeneralSettingResolver $settingsResolver, $key): GeneralSetting
    {
        /** @var RequestStack $requestStack */
        $requestStack = $this->get('request_stack');
        /** @var Request $request */
        $request = $requestStack->getCurrentRequest();
        return $settingsResolver->getSettingItem($key)
            ->setVarKey($key)
            ->setVarValue($request->request->get($key));
    }

    /** @Route ("/content", name="content",  methods= {"GET","POST"})
     * @return Response
     */
    public function listAction()
    {
        /** @var BlogRepository $blogRepository */
        $blogRepository = $this->getDoctrine()->getManager()->getRepository(Blog::class);
        return $this->render('admin/content.twig', [
            'blogs' => $blogRepository->findBy([], ['id' => 'DESC']),
        ]);
    }


    /**
     * @Route("/admin/blog/update_content/{id}",  name ="update_content", methods={"GET", "POST"})
     * @return Response
     */
    public function updateAction(Request $request, Blog $blog)
    {
        $message = '';
        $em = $this->getDoctrine()->getManager();
        if($request->getMethod() === Request::METHOD_POST){
            $blog->setTitle($request->request->get('title'));
            $blog->setBody($request->request->get('body'));
            $this->updateBlogCategory($request, $blog);
            $em->persist($blog);
            $em->flush();

            $message = 'Güncelleme Başarılı...';
        }
        return $this->render('admin/updateContent.twig', [
            'blog' => $blog,
            'categories'=>$this->getDoctrine()->getManager()->getRepository(BlogCategory::class)->findAll(),
            'users' => $this->getDoctrine()->getManager()->getRepository(User::class)->findAll(),
            'message' => $message
        ]);
    }


    /**
     * @Route("/admin/blog/add",  name ="add", methods={"GET", "POST"})
     * @return Response
     */

    public function addAction(Request $request)
    {
        if($request->getMethod() === Request::METHOD_POST){
            $blog = new Blog();

            $blog->setTitle($request->request->get('title'));
            $blog->setBody($request->request->get('body'));
            $blog->setUser($this->findUserById($request->request->get('user_id')));
            $blog->setImage("");
            $blogCategories = $this->findCategoriesByIds($request->request->get("category_ids"));
            /** @var BlogCategory $blogCategory */
            foreach ($blogCategories as $blogCategory){
                $blog->addBlogCategory($blogCategory);
            }

            $this->getDoctrine()->getManager()->persist($blog);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('admin/addContent.twig', [
            'users' => $this->getDoctrine()->getManager()->getRepository(User::class)->findAll(),
            'categories'=>$this->getDoctrine()->getManager()->getRepository(BlogCategory::class)->findAll()
        ]);

    }



    /**
     * @Route("/admin/blog/delete/{id}",  name ="delete", methods={"GET", "POST"})
     * @return Response
     */
    public function deleteAction($id)
    {
        $blog= $this->getDoctrine()->getManager()->getRepository(Blog::class)->find($id);
        $this->getDoctrine()->getManager()->remove($blog);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('admin/content.twig', [
            'blogs'=>$blog,
        ]);

    }

    /**
     * @param $id
     * @return User|null
     */
    protected function findUserById($id)
    {
        /** @var User $user */
        $user =  $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        return $user;
    }

    /**
     * @param Request $request
     * @param Blog $blog
     */
    public function updateBlogCategory(Request $request, Blog $blog): void
    {
        $requestBlogCategoryIds = $request->request->get("category_ids");
        $requestBlogCategories = $this->findCategoriesByIds($requestBlogCategoryIds);
        $existingBlogCategoryIds = [];
        foreach ($blog->getBlogCategories() as $blogCategory) {
            if (!in_array($blogCategory->getId(), $requestBlogCategoryIds)) {
                $blog->removeBlogCategory($blogCategory);
            } else {
                $existingBlogCategoryIds[] = $blogCategory->getId();
            }
        }
        /** @var BlogCategory $requestBlogCategory */
        foreach ($requestBlogCategories as $requestBlogCategory) {
            if (!in_array($requestBlogCategory->getId(), $existingBlogCategoryIds)) {
                $blog->addBlogCategory($requestBlogCategory);
            }
        }
    }

    /**
     * @param $category_id
     * @return BlogCategory|null
     */
    protected function findCategoryById($category_id)
    {
        /** @var BlogCategory $category */
        $category =  $this->getDoctrine()->getManager()->getRepository(BlogCategory::class)->find($category_id);
        return $category;
    }

    /**
     * @param $categoryIds
     * @return object[]
     */
    protected function findCategoriesByIds($categoryIds)
    {
        return $this->getDoctrine()->getManager()->getRepository(BlogCategory::class)->findBy(['id' => $categoryIds]);
    }


    public function getCategories()
    {
        $categories =  $this->getDoctrine()->getManager()->getRepository(BlogCategory::class)->findAll();
        foreach ($categories as $category){
            yield $category;
        }
    }

//    /**
//     * @return User
//     */
//    protected function getUser()
//    {
//        return current($this->getDoctrine()->getManager()->getRepository(User::class)->findAll());
//    }


}
