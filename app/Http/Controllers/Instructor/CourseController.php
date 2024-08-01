<?php

namespace App\Http\Controllers\Instructor; 

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Level;
use App\Models\Price;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Policies\CoursePolicy;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    use AuthorizesRequests;  
    /**
     * Display a listing of the resource.
     */

     //Debo crear las vistas correspondientes: index, create, edit, show
     //Estas vistas extenderán instructor de la carpeta layouts

     //El método index, básicamente me sirve para listar los registros
     public function index()
     {

         // Verifica si el usuario autenticado tiene todos los permisos especificados
         if (
            // Gate::denies('Leer cursos') &&
            Gate::denies('Crear cursos') &&
            Gate::denies('Actualizar cursos') &&
            Gate::denies('Eliminar cursos')
        ) {
            abort(403, 'Unauthorized action.');
        }

         // Recojo la colección de cursos del usuario autenticado 
         $courses = Course::where('user_id', auth()->id())->get();

         // Le paso a la vista la colección de cursos
         return view('instructor.courses.index', compact('courses'));
     }

    //Método para listar todos los cursos
    public function list(){
        
        return view('courses.index');
    }

    /**
     * Show the form for creating a new resource.
     */

     //El método create básicamente me sirve para llevar al usuario a la vista del formulario,
     //el cual capturará los datos introducidos por el usuario
    public function create()
    {

    // Verifica si el usuario autenticado tiene el permiso de 'Editar usuarios'
    if (Gate::denies('Crear cursos')) {
        abort(403, 'Unauthorized action.');
    }
        //Almaceno las colecciones de registros en variables
        $categories= Category::all();
        $levels=Level::all();
        $prices=Price::all();

        //Le mando a la vista las colecciones de variables
        return view('instructor.courses.create', compact('categories', 'levels', 'prices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    //Basicamente lo que hará será apuntar el nuevo curso creado en la bbdd
    public function store(Request $request)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Editar usuarios'
        if (Gate::denies('Crear cursos')) {
            abort(403, 'Unauthorized action.');
        }

        //Valido los campos del formulario, y almaceno la información en una variable
        $data=  $request->validate([
                'title'=>'required',
                'slug'=>'required|unique:courses',
                //Debe existir en la tabla categories
                'category_id'=>'required|exists:categories,id',
                'level_id'=>'required|exists:levels,id',
                'price_id'=>'required|exists:prices,id',
                'image' => 'nullable|image|max:2048',
                'description'=>'nullable',
                'summary'=>'nullable'
                 // Agrega validación para la imagen opcionalmente
        ]);
            //A la variable con los datos del formulario, le paso el id, del usuario ahora mismo autentificado
            $data['user_id']=auth()->id();

            //Creo un curso, y lo almaceno en una variable
            $course=Course::create($data);

        // Guardar imagen...
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses/images');
            $course->courseImage()->create(['path' => $path]);
            $course->update(['image_path' => $path]); // Actualizar image_path en la tabla de cursos
        }


            //Redirijo al usuario a la página de edición, y le paso el nuevo curso
            return redirect()->route('instructor.courses.edit',$course);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {

        //Aplicación de método published de CoursePolicie, para evitar que el usuario acceda
        //a cursos cuyo status sea distinto de 3
        
        // $this->authorize('published', $course);

        //Colección de cursos que son similares al que vió el usuario, y ninguno de ellos, 
        //es ese curso que está viendo el usuario
        $similares=Course::where('category_id', $course->category_id)
                            ->where('id', '!=', $course->id)
                            ->where('status', 3)
                            ->latest('id')
                            ->take(5)
                            ->get();

        // Obtener las 3 últimas reseñas
        $recentReviews = $course->reviews()->latest()->take(3)->get();

        return view('courses.show', compact('course', 'similares', 'recentReviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    //Muestra el formulario de edición del objeto curso
    public function edit(Course $course)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Actualizar cursos'
        // y si es el creador del curso (usuario autenticado debe ser el mismo que el creador del curso)
        if (Gate::denies('Actualizar cursos') || $course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        //En la vista necesito que el usuario tenga disponible estos datos, para que elija el que le parezca, 
        //en un desplegable
        $categories=Category::all();
        $levels=Level::all();
        $prices=Price::all();

        return view('instructor.courses.edit', compact('course','categories','levels','prices'));
    }

    /**
     * Update the specified resource in storage.
     */
    //Método que guarda los cambios en la bbdd//
    public function update(Request $request, Course $course)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Actualizar cursos'
        // y si es el creador del curso (usuario autenticado debe ser el mismo que el creador del curso)
        if (Gate::denies('Actualizar cursos') || $course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'title' => 'required|max:255',
            'slug' => "required|unique:courses,slug,$course->id",
            'summary' => 'nullable|max:500',
            'description' => 'nullable|max:1000',
            'category_id' => 'required|exists:categories,id',
            'level_id' => 'required|exists:levels,id',
            'price_id' => 'required|exists:prices,id',
        ]);
    
        // Limpiar las etiquetas HTML de descripción y summary
        if (isset($data['description'])) {
            $data['description'] = strip_tags($data['description']);
        }
        if (isset($data['summary'])) {
            $data['summary'] = strip_tags($data['summary']);
        }
    
        // Actualizar el curso
        $course->update($data);
    
        // Actualizar imagen...
        if ($request->hasFile('image')) {
            if ($course->courseImage) {
                Storage::delete($course->courseImage->path);
                $course->courseImage->update(['path' => $request->file('image')->store('courses/images')]);
            } else {
                $course->courseImage()->create(['path' => $request->file('image')->store('courses/images')]);
            }
            $course->update(['image_path' => $course->courseImage->path]); // Actualizar image_path en la tabla de cursos
        }
    
        // Utilizo el componente banner.blade.php que vincula a una variable de sesión el mensaje de curso modificado con éxito
        session()->flash('flash.banner', 'El curso se actualizó con éxito');
    
        return redirect()->route('instructor.courses.edit', $course);
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {

        // Verifica si el usuario autenticado tiene el permiso de 'Actualizar cursos'
        // y si es el creador del curso (usuario autenticado debe ser el mismo que el creador del curso)
        if (Gate::denies('Eliminar cursos') || $course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Elimina la imagen si existe
        if ($course->courseImage) {
            Storage::delete($course->courseImage->path);
            $course->courseImage->delete();
        }
    
        // Elimina el curso
        $course->delete();
    
        // Redirige a la vista de la lista de cursos con un mensaje de éxito
        session()->flash('flash.banner', "El curso '{$course->title}' ha sido eliminado con éxito."); 
    
        return redirect()->route('instructor.courses.index');
    }
    
    

    //Método de matriculación
    public function enrolled(Course $course){
        //Para introducir un nuevo registro en la tabla course_user, uso el método attach
        //Ingreso el user que está ahora mismo loggeado
        $course->students()->attach(auth()->user()->id);
        return redirect()->route('courses.status', $course);
    }

    //Método para llevar el curso
    public function status(Course $course){
        return view('courses.status', compact('course'));
    }

    //Probando
        
    // public function instructor(){
    //     return view('courses.instructor');
    // }
    

    //Método para subir un video a un curso
    public function video(Course $course){
        return view('instructor.courses.video', compact('course'));
    }

    //Método para añadir metas a un curso
    public function goals(Course $course){
        return view('instructor.courses.goals', compact('course'));
    }

    //Método para añadir requisitos a un curso
    public function requirements(Course $course){
        return view('instructor.courses.requirements', compact('course'));
    }

    //Método para gestionar el contenido de un curso
    public function curriculum(Course $course){
        return view('instructor.courses.curriculum', compact('course'));
    }


    //Método para listar los cursos de un determinado Estudiante
    public function matriculados()
    {

        return view('courses.matriculados');
    }
    


}
