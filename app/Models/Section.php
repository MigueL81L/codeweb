<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\SectionObserver;

//Le indico al modelo Section que use el observer previamente predefinido, para que anote la posición
#[ObservedBy([SectionObserver::class])]
class Section extends Model
{
    use HasFactory;

    protected $fillable=['name', 'course_id', 'position'];

    //Relación uno a muchos inversa
    public function course(){
        return $this->belongsTo(Course::class);
    }

    //Relación uno a muchos
    public function lessons(){
        return $this->hasMany(Lesson::class)->orderBy('position');
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($section) {
            // Deleting related lessons automatically triggers the deletion of associated files from Lesson's boot method
            $section->lessons()->each(function ($lesson) {
                $lesson->delete();
            });
        });
    }
}
