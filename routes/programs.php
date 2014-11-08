<?php

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