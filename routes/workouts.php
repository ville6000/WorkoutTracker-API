<?php

/**
 * GET request for retrieving all workouts for a user
 */
$app->get('/workouts', function() use ($app) {
    $workouts = ORM::forTable('workout')->where('user_id', 0)->find_array();
    $app->response->body(json_encode($workouts));
});

/**
 * GET request for retrieving all workouts for the program.
 */
$app->get('/workouts/program/:program_id', function ($programId) use ($app) {
    $workouts = ORM::for_table("workout")
        ->where('user_id', 0)
        ->where('program_id', $programId)
        ->find_array();

    $app->response()->body(json_encode($workouts));
});

/**
 * GET request for a single workout
 */
$app->get('/workouts/:workout_id', function($workoutId) use ($app) {
    //@todo We need to take into considerations the currently logged in user.
    $workout = ORM::forTable('workout')->findOne($workoutId);
    $app->response->body(json_encode($workout->asArray()));
});

/**
 * POST request for a workout
 */
$app->post('/workouts', function() use ($app) {
    $requestBody = $app->request()->getBody();
    $requestParams = json_decode($requestBody);
    
    $workout = ORM::forTable('workout')->create();
    // TODO: replace with real user id
    $workout->user_id = 0;
    $workout->program_id    = $requestParams->program_id;
    $workout->date          = $requestParams->date;
    $workout->user_weight   = $requestParams->user_weight;
    $workout->user_rhr      = $requestParams->user_rhr;
    $workout->start_time    = $requestParams->start_time;
    $workout->end_time      = $requestParams->end_time;
    $workout->comments      = $requestParams->comments;

    $workout->save();

    $app->response->body(
        json_encode([
            "workout_id" => $workout->workout_id
        ])
    );
});

/**
 * PUT request for workout
 */
$app->put('/workouts/:workout_id', function($workoutId) use ($app) {
    $requestBody = $app->request()->getBody();
    $requestParams = json_decode($requestBody);

    $workout = ORM::forTable('workout')->findOne($workoutId);

    $workout->user_id = 0;
    $workout->program_id    = $requestParams->program_id;
    $workout->date          = $requestParams->date;
    $workout->user_weight   = $requestParams->user_weight;
    $workout->user_rhr      = $requestParams->user_rhr;
    $workout->start_time    = $requestParams->start_time;
    $workout->end_time      = $requestParams->end_time;
    $workout->comments      = $requestParams->comments;


    if (!$workout->save()) {
        $app->response()->setStatus(500);
    } else {
        echo json_encode( [
            "workout_id" => $workoutId,
        ] );
    }
});

/**
 * DELETE request for workout
 */
$app->delete('/workouts/:workout_id', function($workoutId) use ($app) {
    $program = ORM::forTable('workout')->findOne($workoutId);

     if (!$program->delete()) {
         $app->response()->setStatus(500);
     }
});