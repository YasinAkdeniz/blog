<?php

namespace App\Controller;



use App\Entity\GeneralSetting;
use App\Entity\Blog;
use App\Entity\User;
use App\Repository\BlogRepository;
use App\Resolver\GeneralSettingResolver;
use App\Service\BlogService;
use App\Service\Filter\Event\ResolveEvent;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;


class IndexController extends AbstractController
{

    /**
     * @Route("/", name="index")
     * @return Response
     */

    public function listAction(BlogService $blogService, Request $request, EventDispatcherInterface $eventDispatcher)
    {
        $totalBlogCount = $blogService->getCountByCriteria($request->query->get('q'));
        $paginations = [
            'page' => (int) $request->query->get('page', BlogService::DEFAULT_PAGE),
            'rpp' => (int) $request->query->get('rpp', BlogService::DEFAULT_RPP),
        ];
        return $this->render('list.twig', [
            'total_blog_count' => $totalBlogCount,
            'blogs' => $blogService->findBlogByCriterias($paginations, $request->query->get('q')),
            'settings' => $this->getSettings(),
        ]);
    }
    /**
     *@Route("/blog/{id}", name="blog", methods={"GET", "POST"})
     *@return Response
     */
    public function viewAction($id)
    {
        /** @var BlogRepository $blogRepository */
        $blogRepository = $this->getDoctrine()->getManager()->getRepository(Blog::class);
        $blog = $blogRepository->find($id);
        return $this->render('detail.twig', [
            'blog' => $blog,

        ]);
    }
        /** @Route("/contact", name="blog_contact", methods={"GET", "POST"})
         * @return Response
         */
    public function viewContactAction()
    {
        return $this->render('contact.twig');
    }


    public function resultAction()
    {
        /** @var BlogRepository $blogRepository */
        return $this->render('search.twig', [
            'resultSearch'=> $blogRepository->getSearchResults(),
        ]);
    }




}































//        /**
//         * @Route("/", name="index")
//         * @return Response
//         */
//    public function viewAction($id)
//    {
//        /** @var BlogRepository $blogRepository */
//        $blogRepository = $this->getDoctrine()->getManager()->getRepository(Blog::class);
//        $blog = $blogRepository->find($id);
//        $settings = $this->getDoctrine()->getManager()->getRepository(GeneralSetting::class)->findAll();
//
//        return $this->render('detail.twig', [
//            'blog' => $blog,
//            'settings' => $settings,
//            'recentBlogs' => $blogRepository->getLastFiveBlogEntries(),
//
//        ]);
//    }





