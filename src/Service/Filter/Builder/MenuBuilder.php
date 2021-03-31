<?php


namespace App\Service\Filter\Builder;


use App\Service\Filter\Builder\Strategies\StrategyFactory;
use App\Service\Filter\Event\ResolveEvent;
use App\Service\Filter\Model\Menu\Menu;
use App\Service\Filter\Model\Menu\MenuItem;
use App\Service\Filter\Model\Menu\SubMenu;

/**
 * Class MenuBuilder
 * @package App\Service\Filter\Builder
 */
class MenuBuilder
{
    /**
     * @param ResolveEvent $event
     * @throws \Exception
     */
    public function build(ResolveEvent $event)
    {
        $blogs = $event->getBlogs();
        $categories = StrategyFactory::create('category')->run($blogs);
        $tags = StrategyFactory::create('tag')->run($blogs);
        $this->buildSubMenu($event->getMenu(), 'Kategoriler', $categories);
        $this->buildSubMenu($event->getMenu(), 'Etiketler', $tags);
    }


    /**
     * @param Menu $menu
     * @param $title
     * @param $items
     */
    protected function buildSubMenu(Menu $menu, $title, $items)
    {
        $subMenu = new SubMenu();
        $subMenu->setTitle($title);
        $subMenu->setMenuItems($this->buildMenuItems($items));
        $menu->addSubMenu($subMenu);
    }

    /**
     * @param $items
     * @return array
     */
    protected function buildMenuItems($items)
    {
        $menuItems = [];
        foreach ($items as $item){
            $menuItem = new MenuItem();
            $menuItem->setTitle($item['name']);
            $menuItem->setSlug($item['slug']);
            $menuItem->setCount($item['count']);
            $menuItems[] = $menuItem;
        }
        return $menuItems;
    }

}