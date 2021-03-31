<?php


namespace App\Service;


use App\Repository\BlogRepository;

class BlogService
{
    const DEFAULT_PAGE = 1;
    const DEFAULT_RPP = 20;
    /**
     * @var BlogRepository
     */
    protected $blogRepository;

    /**
     * BlogService constructor.
     * @param BlogRepository $blogRepository
     */
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /***
     * @param $pagination
     * @param $searchParams
     * @return \App\Entity\Blog[]
     */
    public function findBlogByCriterias($pagination, $searchParams)
    {
        $offset = ($pagination["page"] - 1) * $pagination['rpp'];
        $length = $pagination['rpp'];
        return $this->blogRepository->findByCriterias($searchParams, $offset, $length);
    }

    public function getCountByCriteria($searchParams)
    {
        return $this->blogRepository->getCountByCriterias($searchParams);
    }
}