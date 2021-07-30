<?php

namespace App\Http\Controllers;

use App\Actions\AudioConvert;
use App\Actions\DownloadFile;
use App\Models\ConvertJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class FileProcessController extends Controller
{
    public function fileConvertForm()
    {
        return view('home');
    }

    /**
     * main function processing file conversion.
     *
     * @param Request $request
     * @return mixed
     */
    public function processFile(Request $request, AudioConvert $cloudconvert)
    {
        $file = $request->file('file');

        $jobID = ConvertJob::saveJobDetails($request);
        try {
            $cloudconvert->process($jobID, $file);

            $outputFile = '/file_outputs/' . $jobID . '.mp3';
            ConvertJob::updateJobStatus($jobID, 1, $outputFile);

            return ['status' => true, 'job_id' => $jobID];
        } catch (\Exception $ex) {
            Log::alert('An error Occurred while processing the file : ' . $ex->getMessage());
            ConvertJob::updateJobStatus($jobID, 2);
            return ['status' => false, 'job_id' => $jobID];
        }
    }

    /**
     * converted output file downloading function
     *
     * @param $jobID
     * @return mixed
     */
    public function downloadFile($jobID)
    {
        $downloadFile = new DownloadFile($jobID);
        return $downloadFile->download();
    }

    /**
     * Job history
     */
    public function jobHistoryView()
    {
        $details = ConvertJob::select(['*'])->where('user_id', Auth::user()->id)
            ->paginate(20);
        return view('job_history')->with([
            'details' => $details,
        ]);
    }
}
