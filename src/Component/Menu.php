<?php

namespace Snowdog\DevTest\Component;

use DI\InvokerInterface;

class Menu
{
    const CLASS_NAME = 'classname';
    const SORT_ORDER = 'sortorder';
    private static $instance;
    private $items = [];
    /** @var InvokerInterface */
    private $container;

    /** @return Menu */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public static function register($className, $sortOrder)
    {
        $instance = self::getInstance();
        $instance->registerMenuItem($className, $sortOrder);
    }

    public static function setContainer(InvokerInterface $container)
    {
        $instance = self::getInstance();
        $instance->registerContainer($container);
    }

    public function render()
    {
        require __DIR__ . '/../view/menu.phtml';
    }

    private function getMenus()
    {
        usort($this->items, function ($a, $b) {
            if ($a[self::SORT_ORDER] == $b[self::SORT_ORDER]) {
                return 0;
            }
            return ($a[self::SORT_ORDER] < $b[self::SORT_ORDER]) ? -1 : 1;
        });
        $menus = [];
        foreach ($this->items as $menu) {
            $menus[] = $menu[self::CLASS_NAME];
        }
        return $menus;
    }

    private function renderItem($className)
    {
        $this->container->call($className);
    }

    private function registerMenuItem($className, $sortOrder)
    {
        $this->items[] = [
            self::CLASS_NAME => $className,
            self::SORT_ORDER => $sortOrder,
        ];
    }

    private function registerContainer(InvokerInterface $container)
    {
        $this->container = $container;
    }
}