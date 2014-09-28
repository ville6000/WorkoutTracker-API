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
    $exercise = ORM::forTable('exercises')->create();
    $exercise->name = $app->request->post('name');
    $exercise->description = $app->request->post('description');

    return $exercise->save();
});

/**
 * PUT request for exercises
 */
$app->put('/exercises/:id', function($id) use ($app) {
    $exercise = ORM::forTable('exercises')->findOne($id);
    $exercise->name = $app->request->put('name');
    $exercise->description = $app->request->put('description');

    return $exercise->save();
});

/**
 * DELETE request for exercises
 */
$app->delete('/exercises/:id', function($id) use ($app) {
    $exercise = ORM::forTable('exercises')->findOne($id);

    return $exercise->delete();
});

/**
 * GET request for programs
 */
$app->get('/programs', function() use ($app) {
    $programs = ORM::forTable('programs')->findArray();
    $app->response->body(json_encode($programs));
});

/**
 * GET request for single program
 * TODO Access control
 */
$app->get('/programs/:id', function($id) use ($app) {
    $program = ORM::forTable('programs')->findOne($id);
    $app->response->body(json_encode($program->asArray()));
});

/**
 * POST request for programs
 */
$app->post('/programs', function() use ($app) {
    $program = ORM::forTable('programs')->create();
    // TODO: replace with real user id
    $program->user_id = 0;
    $program->name = $app->request->post('name');

    return $program->save();
});

/**
 * PUT request for programs
 * TODO Access control
 */
$app->put('/programs/:id', function($id) use ($app) {
    $program = ORM::forTable('programs')->findOne($id);
    $program->name = $app->request->put('name');

    return $program->save();
});

/**
 * DELETE request for programs
 * TODO Access control
 */
$app->delete('/programs/:id', function($id) use ($app) {
    $program = ORM::forTable('programs')->findOne($id);

    return $program->delete();
});

$app->run();
