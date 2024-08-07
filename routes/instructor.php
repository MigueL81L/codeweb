<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\InstructorController;
use App\Models\Course;
use App\Livewire\Instructor\InstructorCourses;

//Garantizo que todas las rutas presentes en este fichero llevan implementado el middleware(['auth])
//Eso supone que si intento entrar a una de estas url, sin estar loggueado, primero me lleva a la
//página de login y luego me redirige a la url que quería acceder
Route::middleware(['auth'])->group(function () {

    // Redirigir a la lista de cursos cuando se navega a /instructor
    Route::redirect('/', '/instructor/courses')->name('instructor');


    // Las 7 rutas típicas del CRUD de courses
    Route::resource('courses', CourseController::class);

    // Ruta para subir un video a un curso
    Route::get('courses/{course}/video', [CourseController::class, 'video'])->name('courses.video');

    // Ruta para las metas de cada curso
    //Ejemplo de ruta: http://codeweb.test/instructor/courses/Python-Avanzado/goals
    Route::get('courses/{course}/goals', [CourseController::class, 'goals'])->name('courses.goals');

    // Ruta para los requerimientos de cada curso
    Route::get('courses/{course}/requirements', [CourseController::class, 'requirements'])->name('courses.requirements');

    // Ruta para el curriculum de cada curso
    Route::get('courses/{course}/curriculum', [CourseController::class, 'curriculum'])->name('courses.curriculum');



    

    //Ruta para liquidar un course determinado
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('instructor.courses.destroy');



    // Ruta para la pagina del instructor, que mostrará los courses de este
    // Route::get('/instructor-courses/{user}', [InstructorController::class, 'bring'])
    //             ->middleware('can:Leer cursos')
    //             ->name('instructor.instructor-courses');

});



