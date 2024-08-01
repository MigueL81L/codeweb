<?php

namespace App\Observers;
use App\Models\Course;
use App\Models\Section;

class SectionObserver
{
    public function creating(Section $section)
    {
        //Encuentra el máximo valor de posición de todas las metas de un determinado curso
        //y asignaselo sumándole 1
        if (!$section->position) {
            $section->position = Section::where('course_id', $section->course_id)->max('position')+1;
        }
        
    }
}
