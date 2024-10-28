<?php

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

require __DIR__.'/instructor.php';
require __DIR__.'/admin.php';
require __DIR__.'/externos.php';


// Route::middleware(['auth'])->group(function () {

// Route::get('videos/{id}', [\App\Http\Controllers\Instructor\VideoLessonController::class, 'show'])
//     ->name('videos.show');
    

// Route::get('/', HomeController::class)->name('home');
// Route::get('cursos', [CourseController::class, 'list'])->name('courses.index');
// Route::get('cursos/{course}', [CourseController::class, 'show'])->name('courses.show');
// Route::get('courses', [CourseController::class, 'matriculados'])->name('courses.matriculados');

// });


// Route::get('cart', [CartController::class, 'index'])->name('cart.index');
// Route::post('courses/{course}/enrolled', [CourseController::class, 'enrolled'])
// ->middleware('auth')->name('course.enrolled');
// Route::get('course-status/{course}', function (Course $course) {
//     return view('courses.status', ['course' => $course]); 
// })->name('courses.status')->middleware('auth');




// Redirigir a la página de registro si el usuario no está autenticado
Route::get('/', function () {
    return Auth::check() ? redirect()->route('home') : redirect()->route('register');
});

Route::middleware(['auth'])->group(function () {
    // Ruta para mostrar el video de una lección específica de un curso para el que el usuario está matriculado
    Route::get('videos/{id}', [\App\Http\Controllers\Instructor\VideoLessonController::class, 'show'])
        ->name('videos.show');
    
    Route::get('cursos', [CourseController::class, 'list'])->name('courses.index');
    Route::get('cursos/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('courses', [CourseController::class, 'matriculados'])->name('courses.matriculados');
});

Route::get('cart', [CartController::class, 'index'])->name('cart.index');

Route::post('courses/{course}/enrolled', [CourseController::class, 'enrolled'])
    ->middleware('auth')->name('course.enrolled');

Route::get('course-status/{course}', function (Course $course) {
    return view('courses.status', ['course' => $course]); 
})->name('courses.status')->middleware('auth');



