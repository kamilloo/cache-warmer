<?php

namespace Snowdog\DevTest\Menu;

class LoginMenu extends AbstractMenu
{

    public function isActive()
    {
        return $_SERVER['REQUEST_URI'] == '/login';
    }

    public function getHref()
    {
        if(isset($_SESSION['login'])) {
            return '/logout';
        } else {
            return '/login';
        }
    }

    public function getLabel()
    {
        if(isset($_SESSION['login'])) {
            return 'Logout';
        } else {
            return 'Login';
        }
    }
    
}