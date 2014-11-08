<?php 
require 'vendor/autoload.php';
require 'config.php';

$app = new \Slim\Slim($slimSettings);
$app->contentType('application/json');

require 'routes/exercises.php';
require 'routes/programs.php';

$app->run();