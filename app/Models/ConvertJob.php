<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ConvertJob extends Model
{
    use HasFactory;

    public static function saveJobDetails($request)
    {
        $saveJobDetails = new ConvertJob();
        $saveJobDetails->user_id = Auth::user()->id;
        $saveJobDetails->job_number = Str::random(10);
        $saveJobDetails->file_download_name = $request->get('file_name');
        $saveJobDetails->save();
        return $saveJobDetails->id;
    }

    public static function updateJobStatus($jobId, $status, $outputFile = null)
    {
        self::where('id', $jobId)->update([
            'status' => $status,
            'output_file' => $outputFile,
        ]);
    }
}
