<?php

namespace Snowdog\DevTest\Component;

class Migrations
{
    /** @var Migrations */
    private static $instance;
    
    private $components = [];

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public static function registerComponentMigration($component, $version)
    {
        $instance = self::getInstance();
        $instance->addComponentMigration($component, $version);
    }

    private function addComponentMigration($component, $version)
    {
        $this->components[$component] = $version;
    }
    
    public function getComponentMigrations()
    {
        return $this->components;
    }
}