<?php


namespace App\Controller;


use App\Entity\Blog;
use App\Entity\BlogCategory;
use App\Entity\BlogTag;
use App\Repository\BlogCategoryRepository;
use App\Repository\BlogRepository;
use App\Repository\BlogTagRepository;
use App\Service\Filter\Event\ResolveEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class FilterController extends AbstractController
{

    /**
     * @param Request $request
     * @param EventDispatcherInterface $eventDispatcher
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/filter/list", name="filter_ajax_list", methods={"GET"})
     */
    public function listAction(Request $request, EventDispatcherInterface $eventDispatcher){
        $event = new ResolveEvent($request);
        echo "ssss";
        $eventDispatcher->dispatch($event, 'filter.build');

        return $this->render('filter.twig', [
            'filter' => $event->getMenu()
        ]);
    }

    /**
     *@Route ("/blog_tag/{slug}" , name="blog_tag", methods={"GET", "POST"})
     */
    public function viewTag($slug)
    {
        /** @var BlogRepository $blogRepository */
        $blogRepository = $this->getDoctrine()->getManager()->getRepository(Blog::class);

        return $this->render('list.twig', [
            'blogs' => $blogRepository->findByTagSlug($slug),
            'settings' => $this->getSettings()

        ]);

    }

}