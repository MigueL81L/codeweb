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

    public function getCompletedAttribute(){
        return $this->users->contains(auth()->user()->id);
    }

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

    public function getIframeAttribute()
    {
        if ($this->platform == 2) {
            return '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $this->video_path . '" frameborder="0" allowfullscreen></iframe>';
        } elseif ($this->platform == 1) {
            $videoUrl = Storage::url($this->video_path);
            $videoType = $this->getVideoType($this->video_original_name);

            return '<video width="560" height="315" controls>
                        <source src="' . $videoUrl . '" type="' . $videoType . '">
                        Your browser does not support the video tag.
                    </video>';
        }

        return '';
    }

    public static function boot()
    {
        parent::boot();

        //deleting() ya manejado en el LessonObserver.php 03/09
        
        // static::deleting(function ($lesson) {
        //     // Eliminar video si existe
        //     if ($lesson->video_path && Storage::exists($lesson->video_path)) {
        //         Storage::delete($lesson->video_path);
        //     }
            
        //     // Eliminar documento si existe
        //     if ($lesson->document_path && Storage::exists($lesson->document_path)) {
        //         Storage::delete($lesson->document_path);
        //     }
        // });
    }
}




