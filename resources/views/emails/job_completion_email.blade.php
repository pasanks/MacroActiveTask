<!DOCTYPE html>
<html>
<head>
    <title>Online mp3 Converter</title>
</head>
<body>
<h3>{{ $details['title'] }}</h3>
<p>Hi {{$details['user_name']}}, thank you for your patience!</p>
<p>Your mp3 file conversion job (job number : {{$details['job_number']}}) is {{$details['job_status']}}.</p>
<p>Please visit  <a href="{{env('APP_URL')}}/file-download/{{$details['job_id']}}" style="text-decoration: none">
        job history</a> page to download your results.(or re-submit the job if failed)</p>

<p>Thank you</p>
</body>
</html>
