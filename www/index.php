<?php

use Nette\Application\Application;

$container = require __DIR__ . '/../app/bootstrap.php';

$container->getByType(Application::class)->run();
