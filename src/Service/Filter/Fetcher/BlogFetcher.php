<?php


namespace App\Service\Filter\Fetcher;


use App\Entity\Blog;
use App\Repository\BlogRepository;
use App\Service\Filter\Event\ResolveEvent;
use Doctrine\Persistence\ManagerRegistry;

class BlogFetcher
{
    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    /**
     * BlogFetcher constructor.
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->setDoctrine($doctrine);
    }

    /**
     * @return ManagerRegistry
     */
    public function getDoctrine(): ManagerRegistry
    {
        return $this->doctrine;
    }

    /**
     * @param ManagerRegistry $doctrine
     */
    public function setDoctrine(ManagerRegistry $doctrine): void
    {
        $this->doctrine = $doctrine;
    }

    public function fetch(ResolveEvent $event)
    {
        /** @var BlogRepository $blogRepository */
        $blogRepository = $this->getDoctrine()->getManager()->getRepository(Blog::class);
        $blogs = $blogRepository->findByUrlItems($event->getUrlItems());
        $count = $blogRepository->getTotalCountOfByUrlItems($event->getUrlItems());
        $event->setBlogs($blogs);
        $event->setCount($count);
        $this->setSlicedBlogs($event);
    }

    protected function setSlicedBlogs(ResolveEvent $event)
    {
        $urlItems = $event->getUrlItems();
        $firstResult = 0;
        $maxResult = 10;

        if(isset($urlItems['rpp']) && (int)$urlItems['rpp'] > 0){
            $maxResult = (int) $urlItems['rpp'];
        }

        if(isset($urlItems['page']) && (int) $urlItems['page'] > 0){
            $firstResult = (int)($urlItems['page'] - 1) * $maxResult;
        }

        $slicedBlogs = array_slice($event->getBlogs(), $firstResult, $maxResult);
        $event->setSlicedBlogs($slicedBlogs);
    }

}