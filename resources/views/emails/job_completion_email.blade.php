<!DOCTYPE html>
<html>

<head>
    <title>Online mp3 Converter</title>
</head>

<body>
<h3>{{ $details['title'] }}</h3>
<p>Hi {{$details['user_name']}}, thank you for your patience!</p>
<p>Your mp3 file conversion job (job number : {{$details['job_number']}}) is {{$details['job_status']}}.</p>
@if ($details['job_status'] == 'Success')
<p>Please visit <a href="{{$details['download_url']}}" style="text-decoration: none">
        download link</a>  to download your results.</p>
@else
    <p>Please visit job history page and resubmit your job.</p>
@endif
<p>Thank you</p>
</body>

</html>
