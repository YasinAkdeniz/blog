<?php


namespace App\Service\Filter\Model\Menu;

/**
 * Class Menu
 * @package App\Service\Filter\Model\Menu
 */
class Menu
{
    /**
     * @var array
     */
    protected $subMenus = [];

    /**
     * @return array
     */
    public function getSubMenus(): array
    {
        return $this->subMenus;
    }

    /**
     * @param array $subMenus
     */
    public function setSubMenus(array $subMenus): void
    {
        $this->subMenus = $subMenus;
    }

    /**
     * @param $subMenu
     */
    public function addSubMenu($subMenu): void
    {
        $this->subMenus[] = $subMenu;
    }
}