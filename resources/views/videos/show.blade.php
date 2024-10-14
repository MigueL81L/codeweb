<!DOCTYPE html>
<html>
<head>
    <title>Video</title> 
</head>
<body>
    <video width="560" height="315" controls>
        {{-- <source src="{{ Storage::url($lesson->video_path) }}" type="{{ $lesson->getVideoType($lesson->video_original_name) }}"> --}}
        <source src="{{ Storage::url('app/public/' . $lesson->video_path) }}" type="{{ $lesson->getVideoType($lesson->video_original_name) }}">    
        Your browser does not support the video tag.
    </video>
</body>
</html>
