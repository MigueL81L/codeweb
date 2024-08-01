<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\PriceController;
//Aqui iran todas las rutas referidas a  la Adiminstración de la Academia

Route::middleware(['auth'])->group(function () { 


Route::get('/', function () {
    return view('admin.dashboard');
})->middleware('can:Ver dashboard')->name('dashboard');

//Rutas para el crud de roles, las 7 rutas típicas
Route::resource('roles', RoleController::class)->names('admin.roles');

//Rutas para el crud de users, las 7 rutas típicas
Route::resource('users', UserController::class)->names('admin.users');  

// Ruta específica para eliminar usuarios
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

//Ruta específica para la creación de un nuevo user
Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');

//Ruta para la administración de las categorías
Route::resource('categories', CategoryController::class)->names('admin.categories');

//Ruta para la administración de las Niveles de dificultad del curso
Route::resource('levels', LevelController::class)->names('admin.levels');

// Rutas para el crud de prices, las 7 rutas típicas
Route::resource('prices', PriceController::class)->names('admin.prices');

});

