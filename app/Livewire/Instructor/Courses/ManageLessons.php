<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Lesson;
use App\Rules\UniqueLessonCourse;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ManageLessons extends Component
{
    use WithFileUploads;

    public $section;
    public $lessons;
    public $video;
    public $document;
    public $url;

    public $lessonCreate = [
        'open' => false,
        'name' => null,
        'platform' => 1,
        'description' => null,
        'document' => null,
    ];

    public $lessonEdit = [
        'id' => null,
        'name' => null,
        'description' => null,
        'document' => null,
        'document_original_name' => null,
        'document_path' => null,
        'platform' => 1,
        'video' => null,
        'url' => null,
        'existing_video_path' => null,
    ];

    protected $listeners = ['refreshOrderLessons' => 'getLessons'];

    public function mount()
    {
        $this->getLessons();
    }

    public function getLessons()
    {
        $this->lessons = Lesson::where('section_id', $this->section->id)
            ->orderBy('position')
            ->get();
    }

    public function rules()
    {
        return [
            'lessonCreate.name' => ['required', new UniqueLessonCourse($this->section->course_id)],
            'lessonCreate.platform' => 'required|in:1,2',
            'lessonCreate.description' => 'nullable|string',
            'lessonCreate.document' => 'nullable|file|mimes:pdf|max:2048',
        ];
    }

    public function store()
    {
        $this->validate();

        $lessonData = [
            'name' => $this->lessonCreate['name'],
            'description' => $this->lessonCreate['description'],
            'platform' => $this->lessonCreate['platform'],
            'section_id' => $this->section->id,
        ];

        try {
            if ($this->lessonCreate['document'] instanceof UploadedFile) {
                $path = $this->lessonCreate['document']->store('courses/documents', 'public');
                $lessonData['document_path'] = $path;
                $lessonData['document_original_name'] = $this->lessonCreate['document']->getClientOriginalName();
            }

            if ($lessonData['platform'] == 1 && $this->video instanceof UploadedFile) {
                $lessonData['video_path'] = $this->video->store('courses/lessons', 'public');
                $lessonData['video_original_name'] = $this->video->getClientOriginalName();
            } elseif ($lessonData['platform'] == 2) {
                $lessonData['video_path'] = null;
                $lessonData['video_original_name'] = $this->url;
            }

            Lesson::create($lessonData);

            $this->reset(['url', 'lessonCreate', 'video', 'document']);
            $this->getLessons();
            $this->emit('refreshOrderLessons');

        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', ['message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function edit($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $this->lessonEdit = [
            'id' => $lesson->id,
            'name' => $lesson->name,
            'description' => $lesson->description,
            'document' => null,
            'document_path' => $lesson->document_path,
            'document_original_name' => $lesson->document_original_name,
            'platform' => $lesson->platform,
            'url' => $lesson->platform == 2 ? $lesson->video_original_name : null,
            'existing_video_path' => $lesson->platform == 1 ? $lesson->video_path : null,
        ];
    }

    public function update()
    {
        $this->validate([
            'lessonEdit.name' => ['required'],
            'lessonEdit.description' => ['nullable'],
            'lessonEdit.document' => 'nullable|file|mimes:pdf|max:2048',
        ]);
    
        $lesson = Lesson::findOrFail($this->lessonEdit['id']);
    
        try {
            // Update basic lesson information
            $lesson->update([
                'name' => $this->lessonEdit['name'],
                'description' => $this->lessonEdit['description'],
            ]);
    
            // Handle document uploading and updating
            $uploadedDocument = $this->lessonEdit['document'];
            if ($uploadedDocument && $uploadedDocument instanceof UploadedFile) {
                if ($lesson->document_path && Storage::exists($lesson->document_path)) {
                    Storage::delete($lesson->document_path);
                }
                $lesson->document_path = $uploadedDocument->store('courses/documents', 'public');
                $lesson->document_original_name = $uploadedDocument->getClientOriginalName();
            }
    
            // Handle video upload and updating
            $uploadedVideo = $this->lessonEdit['video'];
            if ($lesson->platform == 1 && $uploadedVideo && $uploadedVideo instanceof UploadedFile) {
                if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                    Storage::delete($lesson->video_path);
                }
                $lesson->video_path = $uploadedVideo->store('courses/lessons', 'public');
                $lesson->video_original_name = $uploadedVideo->getClientOriginalName();
            } elseif ($lesson->platform == 2) {
                if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                    Storage::delete($lesson->video_path);
                }
                $lesson->video_path = null;
                $lesson->video_original_name = $this->lessonEdit['url'];
            }
    
            $lesson->save();
    
            $this->reset('lessonEdit');
            $this->getLessons();
    
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', ['message' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    

    public function sortLessons($order)
    {
        foreach ($order as $index => $lessonId) {
            Lesson::findOrFail($lessonId)->update(['position' => $index + 1]);
        }
        $this->getLessons();
        $this->emit('refreshOrderLessons');
    }

    public function destroy($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);

        if ($lesson->video_path && Storage::exists($lesson->video_path)) {
            Storage::delete($lesson->video_path);
        }

        if ($lesson->document_path && Storage::exists($lesson->document_path)) {
            Storage::delete($lesson->document_path);
        }

        $lesson->delete();
        $this->getLessons();
        $this->emit('refreshOrderLessons');
    }

    public function render()
    {
        return view('livewire.instructor.courses.manage-lessons');
    }
}

























































