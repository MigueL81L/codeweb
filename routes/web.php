<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

Route::middleware(['auth'])->group(function () {
    

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




//Rutas de matriculación de usuarios, método enrolled responsable matriculación
//Ruta de Matriculación
Route::post('courses/{course}/enrolled', [CourseController::class, 'enrolled'])
->middleware('auth')->name('course.enrolled');

//Ruta para el control de avance del curso
Route::get('course-status/{course}', function (Course $course) {
    return view('courses.status', ['course' => $course]);
})->name('courses.status')->middleware('auth');







