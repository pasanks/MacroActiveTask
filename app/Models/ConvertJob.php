<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ConvertJob extends Model
{
    use HasFactory;

    public static function updateJobStatus($jobId, $status, $outputFile = null)
    {
        self::where('id', $jobId)->update([
            'status' => $status,
            'output_file' => $outputFile,
        ]);
    }
}
