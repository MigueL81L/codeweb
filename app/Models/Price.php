<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable=['value'];

    // Relación uno a muchos inversa: Un price puede ser tenido por muchos cursos
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
