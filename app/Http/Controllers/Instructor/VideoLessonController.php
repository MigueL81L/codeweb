<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class VideoLessonController extends Controller
{
    public function show($id)
    {
        $lesson = Lesson::findOrFail($id);
        return view('videos.show', compact('lesson')); 
    }
}
