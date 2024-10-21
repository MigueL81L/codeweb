<!DOCTYPE html> 
<html>
<head>
    <title>Video</title> 
    {{-- <style>
        
        .embed-responsive {
            position: relative;
            overflow: hidden;
            padding-top: 56.25%; 
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
    </style> --}}

    <link rel="stylesheet" href="{{ asset('build/assets/app-KEcVs8Hg.css') }}">
    <script src="{{ asset('build/assets/app-49Ykkm2g.js') }}" defer></script>
</head>
    <body>
            <div class="embed-responsive w-full"> <!-- Asegura que ocupa todo el ancho -->
                <video class="w-full h-auto" controls>
                    <source src="{{ Storage::url('app/public/' . $lesson->video_path) }}" type="{{ $lesson->getVideoType($lesson->video_original_name) }}">    
                    Your browser does not support the video tag.
                </video>
            </div>
    </body>
</html>
