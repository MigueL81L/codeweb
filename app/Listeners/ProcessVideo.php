<?php

namespace App\Listeners;

use App\Events\VideoUploaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessVideo implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param VideoUploaded $event
     * @return void
     */
    public function handle(VideoUploaded $event)
    {
        $lesson = $event->lesson;
        
        try {
            if ($lesson->platform == 1) {
                Log::info('Processing video from filesystem', ['lesson_id' => $lesson->id, 'video_path' => $lesson->video_path]);

                // platform == 1: video convencional
                $media = FFMpeg::fromDisk('public')->open($lesson->video_path);

                // Obtengo la duración del video
                $lesson->duration = $media->getDurationInSeconds();
                Log::info('Video duration obtained', ['duration' => $lesson->duration]);

                // Obtengo la imagen de portada, captura de pantalla de un instante determinado
                $lesson->image_path = "courses/lessons/posters/{$lesson->slug}.jpg";

                $media->getFrameFromSeconds(10)
                    ->export()
                    ->toDisk('public')
                    ->save($lesson->image_path);
                
                Log::info('Poster image saved', ['image_path' => $lesson->image_path]);

                $lesson->is_processed = true;
            } else {
                // platform == 2: video de YouTube
                Log::info('Processing video from YouTube', ['lesson_id' => $lesson->id, 'video_url' => $lesson->video_original_name]);
                $patron = '%^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com/(?:embed/|v/|watch\?v=))([\w-]{10,12})%';
                preg_match($patron, $lesson->video_original_name, $matches);

                $lesson->video_path = $matches[1];

                $video_info = Http::get('https://www.googleapis.com/youtube/v3/videos?id=' . $lesson->video_path . '&key=' . config('services.youtube.key') . '&part=snippet,contentDetails,statistics,status')->json();

                $duration = $video_info['items'][0]['contentDetails']['duration'];
                $patron = "%^PT(\d+H)?(\d+M)?(\d+S)?$%";
                preg_match($patron, $duration, $matches);

                $horas = isset($matches[1]) ? (int)substr($matches[1], 0, -1) : 0;
                $minutos = isset($matches[2]) ? (int)substr($matches[2], 0, -1) : 0;
                $segundos = isset($matches[3]) ? (int)substr($matches[3], 0, -1) : 0;

                $lesson->duration = ($horas * 3600) + ($minutos * 60) + $segundos;
                $lesson->image_path = 'https://img.youtube.com/vi/' . $lesson->video_path . '/0.jpg';

                Log::info('YouTube video processed', ['duration' => $lesson->duration, 'image_path' => $lesson->image_path]);

                $lesson->is_processed = true;
            }

            $lesson->save();
            Log::info('Lesson updated', ['lesson' => $lesson->toArray()]);
        } catch (\Exception $e) {
            Log::error('Error processing video', ['message' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);
        }
    }
}

