WorkoutTracker-API
==================

## Routes
### Exercises
- GET /exercises
- POST /exercises
- PUT /exercises/:id
- DELETE /exercises/:id

### Programs
- GET /programs
- GET /programs/:id
- POST /programs
- PUT /programs/:id
- DELETE /programs/:id

### Program exercises
- GET program/:id/exercises
- POST program/:id/exercises
- PUT program/:id/exercises/:program_exercise_id
- DELETE program/:id/exercises/:program_exercise_id

### Workouts
- GET /workouts
- GET /workouts/:workout_id
- POST /workouts
- PUT /workouts/:workout_id
- DELETE /workouts/:workout_id
- GET /workouts/program/:program_id

### Workout Exercises
- GET /workout/:workout_id/exercises
- POST /workouts/:workout_id/exercises
- PUT /workouts/:workout_id/exercises/:workout_exercise_id
- DELETE /workouts/:workout_id/exercises/:workout_exercise_id