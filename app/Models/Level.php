<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable=['name'];



    // Relación uno a muchos inversa: Un nivel puede tener muchos cursos
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
