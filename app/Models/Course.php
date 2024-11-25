<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class Course extends Model
{
    use HasFactory;

    //Propiedad de relleno masivo
    protected $fillable=[
        'title',
        'slug',
        'summary',
        'description',
        'status',
        'image_path',
        'video_path',
        'wellcome_message',
        'goodbye_message',
        'observation',
        'user_id',
        'level_id',
        'category_id',
        'price_id',
        'published_at',
    ];

    protected $guarded=['id', 'status'];

    //Propiedad para contar el número de estudiantes, reviews, ...etc por curso
    protected $withCount=['students', 'reviews'];


    //Quiero añadir un nuevo atributo al modelo, para ello uso public function getModeloAttribute()
    //el Rating
    protected function getRatingAttribute()
    {
        if($this->reviews_count){
            return round($this->reviews()->avg('rating'),1);  
        }else{
            return 0; 
        }
        
    }

    //Query Scopes para CourseIndex, para el filtrado de las categorías y niveles
    //Que solo haga dicho filtrado, si es que existe algo en esa categoría
    public function scopeCategory($query, $category_id){
        if($category_id){
            $query->where('category_id', $category_id);
        }
        return $query;
    }

    public function scopeLevel($query, $level_id){
        if($level_id){
            $query->where('level_id', $level_id);
        }
        return $query;
    }


    
    //Método para que en la url del direccionamiento entregue como parámetro el slug en lugar del id
    //por tema de mejorar el Seo
    public function getRouteKeyName()
    {
        return "slug";
    }

    //Propiedad para que el valor de status solo pueda ser 1, 2 o 3
    protected $casts=[
        'status'=>CourseStatus::class, 
        'published_at'=>'datetime',
    ];

    //Establecer estatus del curso por defecto en 3
    protected static function boot()
    {
        parent::boot();

        // Lógica existente que pudo haber en el método boot
        static::creating(function ($model) {
            // Lógica existente, como establecer valores predeterminados
            if (is_null($model->status)) {
                $model->status = 3;
            }
        });

        // Añadiendo la lógica de eliminación
        static::deleting(function ($course) {
            // Eliminar las secciones asociadas, lo cual también eliminará lessons
            // y disparará su respectivo evento `deleting` para manejar archivos
            $course->sections()->each(function ($section) {
                $section->delete(); // Esto eliminará automáticamente las lessons de la sección
            });
        });
    }


    
   
    //Método accesor concebido para dotar al curso de una nueva propiedad
    protected function image():Attribute
    {
        return new Attribute(
            get:function($value)
            {
                //Retorna la ruta de la imagen, si existe, sino retorna la ruta a una imagen de que falta imagen
                return $this->image_path ? url('storage/app/public/' . $this->image_path): 
                'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0epPorxaqWUlE65AQYNJtbcfwWr2I71b7vOLtRi4PxeiysCeNtmxGvbc_tA&s';
            }
        );
    }


    public function dateOfAcquisition()
    {
        $record = DB::table('course_user')
            ->where('course_id', $this->id)
            ->where('user_id', Auth::id()) // Cambiado de auth()->id() a Auth::id()
            ->first();
    
        return $record ? Carbon::parse($record->created_at) : null;
    }


    //Métodos para relacionar a nivel de modelo las tablas. En esta tabla 
    //son relaciones Uno a Muchos inversa

    //Tendré usuarios que crean cursos, y son por tanto teachers
    //y tendré otros usuarios que consumen cursos, por tanto son students

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function price(){
        return $this->belongsTo(Price::class);
    }

    //Relación uno a muchos
    public function goals(){
        return $this->hasMany(Goal::class)->orderBy('position');
    }

    //Relación Muchos a Muchos
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id')
                ->withTimestamps();
    }

    // Método de relación polimórfica para las imágenes
    public function courseImage()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    //Relación uno a muchos
    public function requirements(){
        return $this->hasMany(Requirement::class)->orderBy('position');
    }
    
    //Relación uno a muchos, un curso, puede tener muchas secciones
    public function sections(){
        return $this->hasMany(Section::class)->orderBy('position');
    }

    //Relación hasManyThrough
    //Aprovechando que existe una relación entre courses y sections, 
    //se crea una relación entre courses y lessons
    public function lessons(){
        return $this->hasManyThrough(Lesson::class, Section::class)->orderBy('position');
    }

    // Método para obtener el valor del precio
    public function getPriceValueAttribute()
    {
        return $this->price ? $this->price->value : 0;
    }


}
