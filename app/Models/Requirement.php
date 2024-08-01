<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\RequirementObserver;

//Le indico al modelo Requirement que use el observer previamente predefinido, para que anote la posición
#[ObservedBy([RequirementObserver::class])]
class Requirement extends Model
{
    use HasFactory;

    protected $fillable=['name', 'course_id', 'position'];
}
