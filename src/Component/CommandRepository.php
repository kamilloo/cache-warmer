<?php

namespace Snowdog\DevTest\Component;


use Silly\Application;

class CommandRepository
{
    private static $instance = null;
    private $commands = [];
    const COMMAND = 'command';
    const CLASS_NAME = 'class_name';


    /**
     * @return CommandRepository
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function registerCommand($command , $className)
    {
        $instance = self::getInstance();
        $instance->addCommand($command, $className);
    }

    public function applyCommands(Application $app)
    {
        foreach ($this->commands as $command) {
            $app->command($command[self::COMMAND], $command[self::CLASS_NAME]);
        }
    }

    private function addCommand($command, $className)
    {
        $this->commands[] = [
            self::COMMAND => $command,
            self::CLASS_NAME => $className,
        ];
    }
}