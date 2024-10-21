<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\LessonObserver;

//Le indico al modelo Lesson que use el observer previamente predefinido, para que anote la posición
#[ObservedBy([LessonObserver::class])]

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'platform',
        'video_path',
        'video_original_name',
        'image_path',
        'document_original_name', // Agrega este campo
        'document_path',          // Agrega este campo también
        'description',
        'duration',
        'position',
        'is_published',
        'is_preview',
        'is_processed',
        'section_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_preview' => 'boolean',
        'is_processed' => 'boolean',
    ];

    // Relaciones y otros métodos...

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    //Atributo completed de la lesson
    public function getCompletedAttribute(){
        return $this->users->contains(auth()->user()->id);
    }

    //Método para determinar el tipo de video, en caso de que sea subido desde el ordenador 
    public function getVideoType($filename)
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
                return 'video/mp4';
        }
    }

    public function getYoutubeEmbedUrl($url)
    {
        preg_match('/(youtube\.com\/(watch\?v=|embed\/|v\/|.+\/)|youtu\.be\/)([\w-]{11})/', $url, $matches);
        $videoId = $matches[3] ?? null;

        if ($videoId) {
            return "https://www.youtube.com/embed/" . $videoId; 
        }

        return null;
    }

    public function getIframeAttribute()
    {
        if ($this->platform == 2 && $this->video_original_name) {
            $embedUrl = $this->getYoutubeEmbedUrl($this->video_original_name);
            if ($embedUrl) {
                return '<iframe width="560" height="315" src="' . $embedUrl . '" frameborder="0" allowfullscreen></iframe>';
            }
        } elseif ($this->platform == 1 && $this->video_path) {
            // $videoUrl = route('instructor.video.show', $this->id);
            $videoUrl = route('videos.show', $this->id);
            return '<iframe width="560" height="315" src="' . $videoUrl . '" frameborder="0" allowfullscreen></iframe>';
        }
    
        return '<p>No hay video disponible para esta lección.</p>';
    }
    
    

    public static function boot()
    {
        parent::boot();

    }
}




