<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseReview extends Component
{
    public $course;
    public $comment;
    public $rating;
    public $reviewId;
    public $isEditing = false;
    public $showForm = false;

    //Para la confirmación de eliminación del SweetAlert
    protected $listeners = ['deleteConfirmed' => 'destroy'];

    protected $rules = [
        'comment' => 'required|string|max:1000',
        'rating' => 'required|integer|min:1|max:5',
    ];

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->index();
    }

    public function index()
    {
        $review = Review::where('user_id', Auth::id())->where('course_id', $this->course->id)->first();
        if ($review) {
            $this->comment = $review->comment;
            $this->rating = $review->rating;
            $this->reviewId = $review->id;
        }
    }

    public function create()
    {
        $this->reset(['comment', 'rating', 'reviewId']);
        $this->showForm = true;
        $this->isEditing = false;
    }

    public function store()
    {
        $this->validate();

        Review::create([
            'comment' => $this->comment,
            'rating' => $this->rating,
            'user_id' => Auth::id(),
            'course_id' => $this->course->id,
        ]);

        session()->flash('success', 'La reseña se creó satisfactoriamente.');

        $this->showForm = false;
        $this->index();
    }

    public function edit()
    {
        $this->showForm = true;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        $review = Review::findOrFail($this->reviewId);
        $review->update([
            'comment' => $this->comment,
            'rating' => $this->rating,
        ]);

        session()->flash('success', 'La reseña se actualizó satisfactoriamente.');

        $this->showForm = false;
        $this->index();
    }

    public function destroy()
    {
        $review = Review::findOrFail($this->reviewId);
        $review->delete();

        $this->reset(['comment', 'rating', 'reviewId']);
        session()->flash('success', 'La reseña se eliminó satisfactoriamente.');

        $this->showForm = false;
    }

    public function cancel()
    {
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.course-review');
    }
}


