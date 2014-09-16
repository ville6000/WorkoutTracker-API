<?php

require 'vendor/autoload.php';
require 'config.php';

$app = new \Slim\Slim(array('debug' => true));
$app->contentType('application/json');

/**
 * GET request for exercises
 */
$app->get('/exercises', function() use ($app) {
    $exercises = ORM::forTable('exercises')->findArray();
    $app->response->body(json_encode($exercises));
});

$app->run();
