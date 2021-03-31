<?php


namespace App\Service\Filter\Event;


use App\Service\Filter\Model\Menu\Menu;
use Symfony\Component\HttpFoundation\Request;

class ResolveEvent
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $urlItems = [];

    /**
     * @var array
     */
    protected $blogs = [];

    /**
     * @var Menu
     */
    protected $menu;

    /**
     * ResolveEvent constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->setRequest($request);
        $this->setMenu(new Menu());
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getUrlItems(): array
    {
        return $this->urlItems;
    }

    /**
     * @param array $urlItems
     */
    public function setUrlItems(array $urlItems): void
    {
        $this->urlItems = $urlItems;
    }

    /**
     * @return array
     */
    public function getBlogs(): array
    {
        return $this->blogs;
    }

    /**
     * @param array $blogs
     */
    public function setBlogs(array $blogs): void
    {
        $this->blogs = $blogs;
    }

    /**
     * @return Menu
     */
    public function getMenu(): Menu
    {
        return $this->menu;
    }

    /**
     * @param Menu $menu
     */
    public function setMenu(Menu $menu): void
    {
        $this->menu = $menu;
    }
}