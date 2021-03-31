<?php


namespace App\Controller;


use App\Entity\Blog;
use App\Entity\BlogCategory;
use App\Repository\BlogCategoryRepository;
use App\repository\BlogRepository;
use App\Resolver\GeneralSettingResolver;
use Symfony\Component\Routing\Annotation\Route;



class BlogCategoryController extends AbstractController
{

    /**
     *@Route("/blog_category/{slug}", name ="blog_category", methods={"GET", "POST"})
     */
    public function viewAction($slug, GeneralSettingResolver $generalSettingResolver)
    {
        /** @var BlogRepository $blogRepository */
        $blogRepository = $this->getDoctrine()->getManager()->getRepository(Blog::class);
        /** @var BlogCategoryRepository $blogCategoryRepository */
        $blogCategoryRepository = $this->getDoctrine()->getManager()->getRepository(BlogCategory::class);

        return $this->render('list.twig', [
            'blogs' => $blogRepository->findByCategorySlug($slug),
            'categories'=>$blogCategoryRepository->findWithCount(),
            'settings' => $this->getSettings()
        ]);
    }
    /**
     *@Route("/blog_categories", name ="blog_category_ajax_list", methods={"GET"})
     */
    public function listAction(BlogCategoryRepository $categoryRepository)
    {
        return $this->render('category_ajax_list.twig', [
            'categories' => $categoryRepository->findWithCount()
        ]);
    }
}