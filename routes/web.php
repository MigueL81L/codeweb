<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Lesson;
use App\Models\Course;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Http;
//Importo un componente livewire
use App\Livewire\CourseStatus;
use Livewire\Livewire;
use App\Http\Controllers\Instructor\InstructorController;

require __DIR__.'/instructor.php';
require __DIR__.'/admin.php';
require __DIR__.'/externos.php';

Route::middleware(['auth'])->group(function () {

// Ruta para mostrar el video de una lección específica de un curso para el que el usuario está matriculado
Route::get('instructor/video/{id}', [\App\Http\Controllers\Instructor\VideoLessonController::class, 'show'])
    ->name('instructor.video.show');
    

Route::get('/', HomeController::class)->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function(){
    return view('dashboard');
})->name('dashboard');

//En el ejemplo es 'index', no 'list'
Route::get('cursos', [CourseController::class, 'list'])->name('courses.index');

Route::get('cursos/{course}', [CourseController::class, 'show'])->name('courses.show');

//Ruta para mostrar al usuario, solo los cursos en los que está matriculado
Route::get('courses', [CourseController::class, 'matriculados'])->name('courses.matriculados');

});


//Ruta del carrito de la compra. En que grupo de rutas va?
Route::get('cart', [CartController::class, 'index'])->name('cart.index');


//Rutas de matriculación de usuarios, método enrolled responsable matriculación
//Ruta de Matriculación
Route::post('courses/{course}/enrolled', [CourseController::class, 'enrolled'])
->middleware('auth')->name('course.enrolled');

//Ruta para el control de avance del curso
Route::get('course-status/{course}', function (Course $course) {
    return view('courses.status', ['course' => $course]); 
})->name('courses.status')->middleware('auth');

Route::get('courses-status/{course}', [CourseController::class, 'status'])
->name('courses.status');






