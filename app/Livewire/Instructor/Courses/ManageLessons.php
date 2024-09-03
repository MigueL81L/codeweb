<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Lesson;
use App\Rules\UniqueLessonCourse;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
            'video' => 'nullable|required_if:lessonCreate.platform,1|file|mimes:mp4|max:256000',
            'url' => 'nullable|required_if:lessonCreate.platform,2|url'
        ];
    }

    public function store()
    {
        try {
            $this->validate();

            DB::beginTransaction();

            $lessonData = [
                'name' => $this->lessonCreate['name'],
                'description' => $this->lessonCreate['description'],
                'platform' => $this->lessonCreate['platform'],
                'section_id' => $this->section->id,
            ];

            // Manejo de documento
            if ($this->lessonCreate['document'] instanceof UploadedFile) {
                $path = $this->lessonCreate['document']->store('courses/documents', 'public');
                if (!$path) {
                    throw new \Exception('Error al guardar el documento.');
                }
                $lessonData['document_path'] = $path;
                $lessonData['document_original_name'] = $this->lessonCreate['document']->getClientOriginalName();
            }

            // Manejo de video
            if ($lessonData['platform'] == 1 && $this->video instanceof UploadedFile) {
                $videoPath = $this->video->store('courses/lessons', 'public');
                if (!$videoPath) {
                    throw new \Exception('Error al guardar el video.');
                }
                $lessonData['video_path'] = $videoPath;
                $lessonData['video_original_name'] = $this->video->getClientOriginalName();
            } elseif ($lessonData['platform'] == 2) {
                $lessonData['video_path'] = null;
                $lessonData['video_original_name'] = $this->url;
            }

            Lesson::create($lessonData);

            DB::commit();

            $this->reset(['url', 'lessonCreate', 'video', 'document']);
            $this->getLessons();
            $this->emit('refreshOrderLessons');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear la lección: ' . $e->getMessage());
            $this->dispatchBrowserEvent('notify', ['message' => 'Error al crear la lección: ' . $e->getMessage()]);
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
        try {
            $this->validate([
                'lessonEdit.name' => ['required'],
                'lessonEdit.description' => ['nullable'],
                'lessonEdit.document' => 'nullable|file|mimes:pdf|max:2048',
                'lessonEdit.video' => 'nullable|file|mimes:mp4|max:256000',
            ]);

            $lesson = Lesson::findOrFail($this->lessonEdit['id']);

            $lesson->update([
                'name' => $this->lessonEdit['name'],
                'description' => $this->lessonEdit['description'],
            ]);

            $uploadedDocument = $this->lessonEdit['document'] ?? null;
            $uploadedVideo = $this->lessonEdit['video'] ?? null;

            if ($uploadedDocument instanceof UploadedFile) {
                if ($lesson->document_path && Storage::exists($lesson->document_path)) {
                    Storage::delete($lesson->document_path);
                }
                $lesson->document_path = $uploadedDocument->store('courses/documents', 'public');
                $lesson->document_original_name = $uploadedDocument->getClientOriginalName();
            }

            if ($lesson->platform == 1 && $uploadedVideo instanceof UploadedFile) {
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
                $lesson->video_original_name = $this->lessonEdit['url'] ?? null;
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
        DB::beginTransaction();

        try {
            $lesson = Lesson::findOrFail($lessonId);

            if ($lesson->video_path && Storage::exists($lesson->video_path)) {
                Storage::delete($lesson->video_path);
            }

            if ($lesson->document_path && Storage::exists($lesson->document_path)) {
                Storage::delete($lesson->document_path);
            }

            $lesson->delete();

            DB::commit();

            $this->getLessons();
            $this->emit('refreshOrderLessons');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar la lección: ' . $e->getMessage());
            $this->dispatchBrowserEvent('notify', ['message' => 'Error al eliminar la lección: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.instructor.courses.manage-lessons');
    }
}



























































