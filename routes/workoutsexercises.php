<?php

/**
 * GET request for retrieving all exercises for a workout.
 */
$app->get('/workouts/:workout_id/exercises', function($workoutId) use ($app) {
    $workoutExercises = ORM::forTable('workout_exercises')->where('workout_id', $workoutId)->find_array();
    $app->response->body(json_encode($workoutExercises));
});


/**
 * POST request for a workout exercise
 */
$app->post('/workouts/:workout_id/exercises', function($workoutId) use ($app) {
    $requestBody = $app->request()->getBody();
    $requestParams = json_decode($requestBody);

    $workoutExercise = ORM::forTable('workout_exercises')->create();

    $workoutExercise->workout_id   = $workoutId;
    $workoutExercise->exercise_id  = $requestParams->exercise_id;
    $workoutExercise->instructions = $requestParams->instructions;
    $workoutExercise->comment      = $requestParams->comment;
    $workoutExercise->order_number = $requestParams->order_number;

    if ($workoutExercise->save()) {
        $app->response->body(
            json_encode([
                "workout_exercise_id" => $workoutExercise->workout_exercise_id
            ])
        );
    } else {
        $app->response()->setStatus(500);
    }
});

/**
 * PUT request for workout exercise
 */
$app->put('/workouts/:workout_id/exercises/:workout_exercise_id', function($workoutId, $workoutExerciseId) use ($app) {
    $requestBody = $app->request()->getBody();
    $requestParams = json_decode($requestBody);

    $workoutExercise = ORM::forTable('workout_exercises')->findOne($workoutExerciseId);

    $workoutExercise->workout_id   = $workoutId;
    $workoutExercise->exercise_id  = $requestParams->exercise_id;
    $workoutExercise->instructions = $requestParams->instructions;
    $workoutExercise->comment      = $requestParams->comment;
    $workoutExercise->order_number = $requestParams->order_number;


    if (!$workoutExercise->save()) {
        $app->response()->setStatus(500);
    }
});

/**
 * DELETE request for workout exercise
 */
$app->delete('/workouts/:workout_id/exercises/:workout_exercise_id', function($workoutId, $workoutExerciseId) use ($app) {
    $workoutExercise = ORM::forTable('workout_exercises')->findOne($workoutExerciseId);

    if (!$workoutExercise->delete()) {
        $app->response()->setStatus(500);
    }
});