<!DOCTYPE html> 
<html>
<head>
    <title>Video</title> 
    <style>
        
        .embed-responsive1 {
            position: relative;
            overflow: hidden;
            padding-top: 56.25%; 
        }

        .embed-responsive1 video,
        .embed-responsive1 iframe {
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
            <div class="embed-responsive1 w-full"> <!-- Asegura que ocupa todo el ancho -->
                <video class="w-full h-auto" controls>
                    <source src="{{ Storage::url('app/public/' . $lesson->video_path) }}" type="{{ $lesson->getVideoType($lesson->video_original_name) }}">    
                    Your browser does not support the video tag.
                </video>
            </div>
    </body>
</html>
