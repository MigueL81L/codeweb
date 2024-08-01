<?php

namespace App\Observers;
use App\Models\Course;
use App\Models\Requirement;

class RequirementObserver
{
    public function creating(Requirement $requirement)
    {
        //Encuentra el máximo valor de posición de todas las metas de un determinado curso
        //y asignaselo sumándole 1
        $requirement->position = Requirement::where('course_id', $requirement->course_id)->max('position')+1;
    }
}
