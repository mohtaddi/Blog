<?php

require __DIR__ . "/vendor/System/Application.php";
require __DIR__ . "/vendor/System/File.php";

use \System\Application;
use \System\File;


$file = new File(__DIR__);
$application = Application::getInstance($file);
$application->run();