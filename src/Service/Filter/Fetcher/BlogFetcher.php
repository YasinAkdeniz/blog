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
        $blogs = $blogRepository->findAll();
        $event->setBlogs($blogs);
    }

}