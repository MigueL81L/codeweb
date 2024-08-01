<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // Importa la clase Storage de Laravel
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\LessonObserver;

//Le indico al modelo Lesson que use el observer previamente predefinido, para que anote la posición
#[ObservedBy([LessonObserver::class])]

class Lesson extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'slug',
        'platform',
        'video_path',
        'video_original_name',
        'image_path',
        'description',
        'duration',
        'position',
        'is_published',
        'is_preview',
        'is_processed',
        'section_id',
    ];

    // protected $guarded=['id'];

    protected $casts=[
        'is_published'=>'boolean',
        'is_preview'=>'boolean',
        'is_processed'=>'boolean',
    ];

    //Relación uno a muchos inversa
    public function section(){
        return $this->belongsTo(Section::class);
    }


    // Relación uno a uno
    // public function description(){
    //     return $this->hasOne('App\Models\Description');
    // }

    
    // public function platform(){
    //     return $this->belonsTo('App\Models\Platform');
    // }

    // Relación muchos a muchos
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getCompletedAttribute(){
        return $this->users->contains(auth()->user()->id);
    }

    // Método para determinar el tipo MIME del video basado en su extensión
    private function getVideoType($filename)
    {
         $extension = pathinfo($filename, PATHINFO_EXTENSION);
    
        switch ($extension) {
            case 'mp4':
                return 'video/mp4';
            case 'mov':
                return 'video/quicktime';
            case 'avi':
                return 'video/x-msvideo';
            case 'wmv':
                return 'video/x-ms-wmv';
            case 'flv':
                return 'video/x-flv';
            case '3gp':
                return 'video/3gpp';
            default:
                return 'video/mp4'; // Valor predeterminado
        }
    }

    // Accesor para generar el iframe de video
    protected function getIframeAttribute()
    {
        if ($this->platform == 2) { // YouTube
            return '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $this->video_path . '" frameborder="0" allowfullscreen></iframe>';
        } elseif ($this->platform == 1) { // Normal Video
            $videoUrl = Storage::url($this->video_path);
            $videoType = $this->getVideoType($this->video_original_name);

            return '<video width="560" height="315" controls>
                        <source src="' . $videoUrl . '" type="' . $videoType . '">
                        Your browser does not support the video tag.
                    </video>';
        }

        return '';
    }
    

}



