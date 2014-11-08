<?php

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
	$requestBody = $app->request()->getBody();
	$requestParams = json_decode($requestBody);

	$uniqueCheck = ORM::forTable('exercises')->where('name', $requestParams->name)->findOne();
    $isUniqueName = empty($uniqueCheck);

    if ($isUniqueName) {
        $exercise = ORM::forTable('exercises')->create();
        $exercise->name = $requestParams->name;
        $exercise->description = $requestParams->description;

        $exercise->save();

        echo json_encode([
            "exercise_id" => $exercise->id()
        ]);
    }
});

/**
 * PUT request for exercises
 */
$app->put('/exercises/:id', function($id) use ($app) {
	$requestBody = $app->request()->getBody();
	$requestParams = json_decode($requestBody);

    $uniqueCheck = ORM::forTable('exercises')->where('name', $requestParams->name)->findOne();
    $isUniqueName = empty($uniqueCheck);

    if ($isUniqueName) {
        $exercise = ORM::forTable( 'exercises' )->findOne( $id );
        $exercise->name = $requestParams->name;
        $exercise->description = $requestParams->description;

        $exercise->save();

        echo json_encode( [
            "name" => $requestParams->name,
            "description" => $requestParams->description
        ] );
    }
});

/**
 * DELETE request for exercises
 */
$app->delete('/exercises/:id', function($id) use ($app) {
	$exercise = ORM::forTable('exercises')->findOne($id);

	return $exercise->delete();
});