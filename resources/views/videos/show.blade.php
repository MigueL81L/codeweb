<!DOCTYPE html> 
<html>
<head>
    <title>Video</title> 
    <style>
        /* Clase para mantener la relación de aspecto */
        .embed-responsive {
            position: relative;
            overflow: hidden;
            padding-top: 56.25%; /* Relación de aspecto 16:9 */
        }

        .embed-responsive video,
        .embed-responsive iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
</head>
    <body>
            {{-- <video width="560" height="315" controls>
                <source src="{{ Storage::url('app/public/' . $lesson->video_path) }}" type="{{ $lesson->getVideoType($lesson->video_original_name) }}">    
                Your browser does not support the video tag.
            </video> --}}
            <div class="embed-responsive w-full"> <!-- Asegura que ocupa todo el ancho -->
                <video class="w-full h-auto" controls>
                    <source src="{{ Storage::url('app/public/' . $lesson->video_path) }}" type="{{ $lesson->getVideoType($lesson->video_original_name) }}">    
                    Your browser does not support the video tag.
                </video>
            </div>
    </body>
</html>
