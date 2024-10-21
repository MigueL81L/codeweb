<!DOCTYPE html> 
<html>
<head>
    <title>Video</title> 
</head>
    <body>
            {{-- <video width="560" height="315" controls>
                <source src="{{ Storage::url('app/public/' . $lesson->video_path) }}" type="{{ $lesson->getVideoType($lesson->video_original_name) }}">    
                Your browser does not support the video tag.
            </video> --}}
            <div class=" w-full embed-responsive"> <!-- Mantiene la relación de aspecto -->
                <video class="w-full h-auto" controls>
                    <source src="{{ Storage::url('app/public/' . $lesson->video_path) }}" type="{{ $lesson->getVideoType($lesson->video_original_name )}}">    
                    Your browser does not support the video tag.
                </video>
            </div>
    </body>
</html>
