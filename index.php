<?php

require 'vendor/autoload.php';
require 'config.php';

$app = new \Slim\Slim($slimSettings);
$app->contentType('application/json');

/**
 * GET request for exercises
 */
$app->get('/exercises', function() use ($app) {
    $exercises = ORM::forTable('exercises')->findArray();
    $app->response->body(json_encode($exercises));
});

/**
 * POST request for exercises
 */
$app->post('/exercises', function() use ($app) {
    $exercise = ORM::for_table('exercises')->create();
    $exercise->name = $app->request->post('name');
    $exercise->description = $app->request->post('description');

    return $exercise->save();
});

/**
 * PUT request for exercises
 */
$app->put('/exercises/:id', function($id) use ($app) {
    $exercise = ORM::for_table('exercises')->findOne($id);
    $exercise->name = $app->request->put('name');
    $exercise->description = $app->request->put('description');

    return $exercise->save();
});

/**
 * DELETE request for exercises
 */
$app->delete('/exercises/:id', function($id) use ($app) {
    $exercise = ORM::for_table('exercises')->findOne($id);

    return $exercise->delete();
});

$app->run();
