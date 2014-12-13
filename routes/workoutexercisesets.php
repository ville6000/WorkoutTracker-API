<?php

/**
 * GET request for retrieving all sets for an exercise.
 */
$app->get('/workoutexercise/:workout_exercise_id/sets', function($workoutExerciseId) use ($app) {
    $workoutExerciseSets = ORM::forTable('workout_exercise_sets')->where('workout_exercise_id', $workoutExerciseId)->find_array();
    $app->response->body(json_encode($workoutExerciseSets));
});

$app->get('/workout/:workout_id/exercise/sets', function ($workoutId) use ($app) {
    $workoutExerciseSets = ORM::for_table('workout')
        ->select('workout_exercise_sets.*')
        ->where('workout.workout_id', $workoutId)
        ->join('workout_exercises', array("workout.workout_id", "=", "workout_exercises.workout_id"))
        ->join('workout_exercise_sets', array("workout_exercises.workout_exercise_id", "=", "workout_exercise_sets.workout_exercise_id"))
        ->find_array();

    $app->response->body(json_encode($workoutExerciseSets));
});


/**
 * POST request for a workout exercise
 */
$app->post('/workoutexercise/:workout_exercise_id/sets', function($workoutExerciseId) use ($app) {
    $requestBody = $app->request()->getBody();
    $requestParams = json_decode($requestBody);

    $workoutExerciseSet = ORM::forTable('workout_exercise_sets')->create();

    $workoutExerciseSet->workout_exercise_id = $workoutExerciseId;
    $workoutExerciseSet->set_number          = $requestParams->set_number;
    $workoutExerciseSet->repetitions         = $requestParams->repetitions;
    $workoutExerciseSet->load_type_id        = $requestParams->load_type_id;
    $workoutExerciseSet->load                = $requestParams->load;


    if ($workoutExerciseSet->save()) {
        $app->response->body(
            json_encode([
                "workout_exercise_set_id" => $workoutExerciseSet->workout_exercise_set_id
            ])
        );
    } else {
        $app->response()->setStatus(500);
    }
});

/**
 * PUT request for workout exercise
 */
$app->put('/workoutexercise/:workout_exercise_id/sets/:workout_exercise_set_id', function($workoutExerciseId, $workoutExerciseSetId) use ($app) {
    $requestBody = $app->request()->getBody();
    $requestParams = json_decode($requestBody);

    $workoutExerciseSet = ORM::forTable('workout_exercise_sets')->findOne($workoutExerciseSetId);

    $workoutExerciseSet->set_number          = $requestParams->set_number;
    $workoutExerciseSet->repetitions         = $requestParams->repetitions;
    $workoutExerciseSet->load_type_id        = $requestParams->load_type_id;
    $workoutExerciseSet->load                = $requestParams->load;


    if (!$workoutExerciseSet->save()) {
        $app->response()->setStatus(500);
    }
});

/**
 * DELETE request for workout exercise
 */
$app->delete('/workoutexercisesets/:workout_exercise_set_id', function($workoutExerciseSetId) use ($app) {
    $workoutExercise = ORM::forTable('workout_exercise_sets')->findOne($workoutExerciseSetId);

    if (!$workoutExercise->delete()) {
        $app->response()->setStatus(500);
    }
});