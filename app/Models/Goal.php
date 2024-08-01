<?php

namespace App\Models;

use App\Observers\GoalObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

//Le indico al modelo Goal que use el observer previamente predefinido, para que anote la posición
#[ObservedBy([GoalObserver::class])]

class Goal extends Model
{
    use HasFactory;

    protected $fillable=['name', 'course_id', 'position'];
}
