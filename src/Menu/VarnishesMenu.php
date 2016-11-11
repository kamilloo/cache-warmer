<?php

namespace Snowdog\DevTest\Menu;

class VarnishesMenu extends AbstractMenu
{

    public function isActive()
    {
        return $_SERVER['REQUEST_URI'] == '/varnish';
    }

    public function getHref()
    {
        return '/varnish';
    }

    public function getLabel()
    {
        return 'Varnishes';
    }

     public function __invoke()
    {
        if (isset($_SESSION['login'])) {
            parent::__invoke();
        }
    }
}