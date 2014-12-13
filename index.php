<?php 
require 'vendor/autoload.php';
require 'config.php';

$app = new \Slim\Slim($slimSettings);
$app->contentType('application/json');

require 'routes/exercises.php';
require 'routes/programs.php';
require 'routes/programsexercises.php';
require 'routes/workouts.php';
require 'routes/workoutsexercises.php';
require 'routes/workoutexercisesets.php';

$app->run();