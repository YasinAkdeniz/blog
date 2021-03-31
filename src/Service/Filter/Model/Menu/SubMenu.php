<?php


namespace App\Service\Filter\Model\Menu;

/**
 * Class SubMenu
 * @package App\Service\Filter\Model\Menu
 */
class SubMenu
{
    /**
     * @var string | null
     */
    protected $title;

    /**
     * @var array
     */
    protected $menuItems = [];

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function getMenuItems(): array
    {
        return $this->menuItems;
    }

    /**
     * @param array $menuItems
     */
    public function setMenuItems(array $menuItems): void
    {
        $this->menuItems = $menuItems;
    }

    /**
     * @param $menuItem
     */
    public function addMenuItem($menuItem)
    {
        $this->menuItems[] = $menuItem;
    }
}