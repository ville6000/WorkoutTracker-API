<?php
/**
 * GET program exercises
 */
$app->get('/programs/:id/exercises', function($programId) use ($app) {
    $programExercises = ORM::for_table('program_exercises')
        ->where('program_id', $programId)
        ->find_array();
    $app->response->body(json_encode($programExercises));
});


/**
 * Add a program exercise
 */
$app->post('/programs/:id/exercises', function ($programId) use ($app) {
    $requestBody = $app->request()->getBody();
    $requestParams = json_decode($requestBody);

    $programExercise = ORM::for_table('program_exercises')->create();

    $programExercise->program_id = $programId;
    $programExercise->exercise_id = $requestParams->exercise_id;
    $programExercise->order_number = $requestParams->order_number;

    $programExercise->save();

    echo json_encode([
        "program_exercise_id" => $programExercise->id()
    ]);
});

/**
 * Update a program exercise
 */
$app->put('/programs/:program_id/exercises/:program_exercise_id', function ($programId, $programExerciseId) use ($app) {
    $requestBody = $app->request()->getBody();
    $requestParams = json_decode($requestBody);

    $programExercise = ORM::for_table('program_exercises')->find_one($programExerciseId);

    $programExercise->program_id = $programId;
    $programExercise->exercise_id = $requestParams->exercise_id;
    $programExercise->order_number = $requestParams->order_number;

    $programExercise->save();

    $programExercise = ORM::for_table('program_exercises')->find_one($programExerciseId)->as_array();

    echo json_encode($programExercise);
});

/**
 * Delete a program exercise id.
 */
$app->delete('/programs/:program_id/exercises/:program_exercise_id', function($programId, $programExerciseId) use ($app) {
    $programExercise = ORM::forTable('program_exercises')->findOne($programExerciseId);

    $programExercise->delete();

    $app->response()->setStatus(200);
});