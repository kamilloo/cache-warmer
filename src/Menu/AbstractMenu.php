<?php

namespace Snowdog\DevTest\Menu;

abstract class AbstractMenu
{
    
    public abstract function isActive();
    
    public abstract function getHref();
    
    public abstract function getLabel();
    
    public function __invoke()
    {
        require __DIR__ . '/../view/menu_item.phtml';
    }
}