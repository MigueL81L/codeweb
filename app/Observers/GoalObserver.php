<?php

namespace App\Observers;
use App\Models\Goal;

class GoalObserver
{
    //Escucha el momento justo antes de que se cree una nueva meta
    public function creating(Goal $goal)
    {
        //Encuentra el máximo valor de posición de todas las metas de un determinado curso
        //y asignaselo sumándole 1
        $goal->position = Goal::where('course_id', $goal->course_id)->max('position')+1;
    }
}
