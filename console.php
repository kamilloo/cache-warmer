<?php

use Silly\Application;
use Snowdog\DevTest\Component\CommandRepository;

$container = require __DIR__ . '/app/bootstrap.php';

$app = new Application();
$app->useContainer($container, true);

$commandRepository = CommandRepository::getInstance();
$commandRepository->applyCommands($app);

$app->run();
